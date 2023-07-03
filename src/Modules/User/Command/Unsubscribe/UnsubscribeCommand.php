<?php

declare(strict_types=1);

namespace App\Modules\User\Command\Unsubscribe;

use Symfony\Component\Validator\Constraints as Assert;

final class UnsubscribeCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly int $userId,
        #[Assert\NotBlank]
        public readonly int $profileId,
    ) {
    }
}
