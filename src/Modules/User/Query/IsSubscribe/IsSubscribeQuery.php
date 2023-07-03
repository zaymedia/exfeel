<?php

declare(strict_types=1);

namespace App\Modules\User\Query\IsSubscribe;

use Symfony\Component\Validator\Constraints as Assert;

final class IsSubscribeQuery
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly int $userId,
        #[Assert\NotBlank]
        public readonly int $profileId,
    ) {
    }
}
