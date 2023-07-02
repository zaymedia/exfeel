<?php

declare(strict_types=1);

namespace App\Modules\User\Command\UpdateLanguage;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateLanguageCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly int $userId,
        #[Assert\NotBlank]
        public readonly string $language,
    ) {
    }
}
