<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Query\Stories\GetByUserId;

use Symfony\Component\Validator\Constraints as Assert;

final class GetByUserIdQuery
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly int $userId,
        public readonly int $sort = 0,
        public readonly int $count = 100,
        public readonly ?string $cursor = null,
    ) {
    }
}
