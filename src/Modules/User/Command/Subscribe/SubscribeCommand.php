<?php

declare(strict_types=1);

namespace App\Modules\User\Command\Subscribe;

use Symfony\Component\Validator\Constraints as Assert;

final class SubscribeCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly int $userId,
        #[Assert\NotBlank]
        public readonly int $profileId,
    ) {
    }
}
