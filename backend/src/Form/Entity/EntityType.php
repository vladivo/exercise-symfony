<?php

declare(strict_types=1);

namespace App\Form\Entity;

use App\Attribute\PropertyFormField;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ReflectionClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fields = new ArrayCollection();
        $this->getFieldsRecursively(new ReflectionClass($builder->getData()), $fields);

        foreach ($fields as $name => $config) {
            assert($config instanceof PropertyFormField);
            $builder->add($name, $config->getType(), $config->getOptions());
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('data');
    }

    /**
     * @param Collection<PropertyFormField> $fields
     */
    private function getFieldsRecursively(ReflectionClass $reflectionClass, Collection $fields): void
    {
        $parent = $reflectionClass->getParentClass();
        if ($parent !== false) {
            $this->getFieldsRecursively($parent, $fields);
        }

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $reflectionAttributes = $reflectionProperty->getAttributes(PropertyFormField::class);
            if (count($reflectionAttributes) !== 0) {
                $fields->set($reflectionProperty->getName(), $reflectionAttributes[0]->newInstance());
            }
        }
    }
}
