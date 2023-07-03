<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Query\Profile\Search;

use Symfony\Component\Validator\Constraints as Assert;

final class Query
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $username,
    ) {
    }
}
