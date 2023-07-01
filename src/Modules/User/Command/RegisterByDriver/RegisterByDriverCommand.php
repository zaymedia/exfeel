<?php

declare(strict_types=1);

namespace App\Modules\User\Command\RegisterByDriver;

use Symfony\Component\Validator\Constraints as Assert;

final class RegisterByDriverCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $driver,
        #[Assert\NotBlank]
        public readonly string $userId,
        public readonly ?string $username,
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $language,
    ) {
    }
}
