<?php

declare(strict_types=1);

namespace App\Modules\User\Query\GetSubscriptions;

use App\Modules\Instagram\Entity\Profile\Profile;
use App\Modules\User\Entity\UserSubscription\UserSubscription;
use Doctrine\DBAL\Connection;

final class GetSubscriptionsFetcher
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function fetch(GetSubscriptionsQuery $query): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        return $queryBuilder
            ->select('p.*')
            ->from(UserSubscription::DB_NAME, 'us')
            ->leftJoin('us', Profile::DB_NAME, 'p', 'p.id = us.instagram_profile_id')
            ->andWhere('us.user_id = ' . $query->userId)
            ->andWhere('us.unsubscribed_at IS NULL')
            ->setMaxResults($query->count)
            ->setFirstResult($query->offset)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
