<?php

declare(strict_types=1);

namespace App\Modules\User\Query\IsSubscribe;

use App\Modules\User\Entity\UserSubscription\UserSubscriptionRepository;

final class Fetcher
{
    public function __construct(
        private readonly UserSubscriptionRepository $userSubscriptionRepository,
    ) {
    }

    public function fetch(Query $query): bool
    {
        $subscription = $this->userSubscriptionRepository->findByUserAndProfileIds(
            userId: $query->userId,
            profileId: $query->profileId
        );

        return null !== $subscription;
    }
}
