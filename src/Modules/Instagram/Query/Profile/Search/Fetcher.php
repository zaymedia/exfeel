<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Query\Profile\Search;

use App\Modules\Instagram\Entity\Profile\Profile;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class Fetcher
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    /** @throws Exception */
    public function fetch(Query $query): ?array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $profile = $queryBuilder
            ->select('p.*')
            ->from(Profile::DB_NAME, 'p')
            ->andWhere('p.username = :username')
            ->setParameter('username', $query->username)
            ->executeQuery()
            ->fetchAssociative();

        if (empty($profile)) {
            return null;
        }

        return $profile;
    }
}
