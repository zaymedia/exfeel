<?php

declare(strict_types=1);

namespace App\Modules\User\Query\IsSubscribe;

use App\Modules\User\Entity\UserSubscription\UserSubscriptionRepository;

final class IsSubscribeFetcher
{
    public function __construct(
        private readonly UserSubscriptionRepository $userSubscriptionRepository,
    ) {
    }

    public function fetch(IsSubscribeQuery $query): bool
    {
        $subscription = $this->userSubscriptionRepository->findByUserAndProfileIds(
            userId: $query->userId,
            profileId: $query->profileId
        );

        return null !== $subscription && null === $subscription->getUnsubscribedAt();
    }
}
