<?php

declare(strict_types=1);

namespace App\Command\Application;

use App\Attribute\EntityPermissions as PermissionsAttribute;
use App\Entity\Entity;
use App\Entity\User\Account;
use App\Entity\User\Permission;
use App\Entity\User\Role;
use App\Model\Permission\EntityAction;
use App\Utils\Entity\TypeMapper\DefaultTypeMapper;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;
use Throwable;
use function array_filter;
use function assert;
use function class_implements;
use function count;
use function get_declared_classes;
use function implode;
use function in_array;
use function sha1;
use function random_bytes;

final class InstallApplicationCommand extends Command
{
    protected static $defaultName = 'application:install';
    protected static $defaultDescription = 'Initialize database with default roles, permissions, and users';

    private StyleInterface $io;
    private OutputInterface $output;
    private array $installConfig;

    public function __construct(
        private EntityManagerInterface $entityManager,
        string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->installConfig = Yaml::parseFile('/app/config/application/install.yml');

            $this->io = new SymfonyStyle($input, $output);
            $this->output = $output;

            if (!$this->io->confirm('This command will clear your database and recreate all data', false)) {
                return Command::SUCCESS;
            }

            $this->prepareDatabase();
            $this->createPermissions();
            $this->createRoles();
            $this->createAdminUser();
            $this->postInstall();

            $this->io->success('Application has been initialized');

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->io->error('cannot initialize application');
            $this->io->error((string) $e);

            return Command::FAILURE;
        }
    }

    private function prepareDatabase(): void
    {
        $this->io->section('Prepare database');

        $command = $this->getApplication()->find('doctrine:database:drop');
        $input = new ArrayInput(['--force' => true, '--if-exists' => true], $command->getDefinition());
        $command->execute($input, $this->output);

        $command = $this->getApplication()->find('doctrine:database:create');
        $input = new ArrayInput([], $command->getDefinition());
        $command->execute($input, $this->output);

        $command = $this->getApplication()->find('doctrine:schema:create');
        $input = new ArrayInput([], $command->getDefinition());
        $command->execute($input, $this->output);

        $this->io->newLine(2);
    }

    private function createPermissions(): void
    {
        $this->io->section('Create permissions');

        $entityImplementations = array_filter(
            get_declared_classes(),
            static fn($className) => in_array(Entity::class, class_implements($className), true),
        );

        foreach ($entityImplementations as $className) {
            $reflectionClass = new ReflectionClass($className);
            if ($reflectionClass->isInterface() || $reflectionClass->isAbstract()) {
                continue;
            }

            $reflectionAttributes = $reflectionClass->getAttributes(PermissionsAttribute::class);
            if (count($reflectionAttributes) === 0) {
                continue;
            }

            $type = DefaultTypeMapper::mapClassToType($className);
            $attribute = $reflectionAttributes[0]->newInstance();
            assert($attribute instanceof PermissionsAttribute);

            foreach ($attribute->getCategories() as $category) {
                foreach (EntityAction::getCategory($category) as $action) {
                    $permission = new Permission();
                    $permission->setInternal(true);
                    $permission->setName(sprintf('%s_%s', $action, $type));
                    $this->entityManager->persist($permission);
                }
            }
        }

        $this->entityManager->flush();

        $this->io->newLine(2);
    }

    private function createRoles(): void
    {
        $this->io->section('Create roles');

        foreach ($this->installConfig['roles'] as $definition) {
            $this->io->text(sprintf(
                '%s: %s',
                $definition['name'],
                implode(', ', $definition['permissions'])
            ));

            $role = new Role();
            $role->setName($definition['name']);
            $role->setTitle($definition['title']);
            $role->setInternal(true);

            $permissionRepository = $this->entityManager->getRepository(Permission::class);
            $permissions = $permissionRepository->findBy([
                'name' => $definition['permissions']
            ]);

            foreach($permissions as $permission) {
                $role->getPermissions()->add($permission);
            }

            $this->entityManager->persist($role);
        }

        $this->entityManager->flush();

        $this->io->newLine(2);
    }

    private function createAdminUser(): void
    {
        $this->io->section('Create admin user');

        $name = $this->io->ask('User name', 'admin');
        $email = $this->io->ask('Mail', 'admin@example.com');

        $password = $this->io->askHidden('Password');
        if ($password === null) {
            $this->io->text('Empty password given. Using random value.');
            $password = sha1(random_bytes(8));
        }

        $account = new Account();
        $account->setName($name);
        $account->setMail($email);
        $account->setPassword($password);
        $account->setEnabled(true);
        $account->setInternal(true);

        $roles = $account->getRoles();
        $roles->add($this->entityManager->find(Role::class, Role::ID_AUTHENTICATED));
        $roles->add($this->entityManager->find(Role::class, Role::ID_ADMINISTRATOR));

        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    private function postInstall(): void
    {
        $this->io->section('Execute post-install commands');

        $command = $this->getApplication()->find('cache:clear');
        $input = new ArrayInput([], $command->getDefinition());
        $command->execute($input, $this->output);

        $command = $this->getApplication()->find('assets:install');
        $input = new ArrayInput([], $command->getDefinition());
        $command->execute($input, $this->output);
    }
}
