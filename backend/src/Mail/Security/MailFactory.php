<?php

declare(strict_types=1);

namespace App\Mail\Security;

use App\Entity\User\Account;
use Symfony\Component\Mime\Email;

interface MailFactory
{
    public function createOneTimeLoginMail(Account $account, string $link): Email;
}
