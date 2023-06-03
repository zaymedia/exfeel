<?php

declare(strict_types=1);

namespace App\Modules\OAuth\Command\LogOut;

use Symfony\Component\Validator\Constraints as Assert;

final class LogOutCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $refreshToken
    ) {
    }
}
