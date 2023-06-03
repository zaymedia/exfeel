<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Query\Stories\GetByUserId;

use App\Modules\Instagram\Entity\Stories\Stories;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use ZayMedia\Shared\Helpers\CursorPagination\CursorPagination;
use ZayMedia\Shared\Helpers\CursorPagination\CursorPaginationResult;

final class Fetcher
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    /** @throws Exception */
    public function fetch(Query $query): CursorPaginationResult
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $sqlQuery = $queryBuilder
            ->select('s.*')
            ->from(Stories::DB_NAME, 's')
            ->andWhere('s.user_id = ' . $query->userId);

        return CursorPagination::generateResult(
            query: $sqlQuery,
            cursor: $query->cursor,
            count: $query->count,
            isSortDescending: !$query->sort,
            orderingBy: [
                's.id' => 'DESC',
            ],
            field: 's.id',
        );
    }
}
