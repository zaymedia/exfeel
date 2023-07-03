<?php

declare(strict_types=1);

namespace App\Modules\User\Command\Unsubscribe;

use App\Modules\Instagram\Entity\Profile\ProfileRepository;
use App\Modules\User\Entity\User\UserRepository;
use App\Modules\User\Entity\UserSubscription\UserSubscriptionRepository;
use ZayMedia\Shared\Components\Flusher;

final class UnsubscribeHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserSubscriptionRepository $userSubscriptionRepository,
        private readonly ProfileRepository $profileRepository,
        private readonly Flusher $flusher
    ) {
    }

    public function handle(UnsubscribeCommand $command): void
    {
        $user = $this->userRepository->getById($command->userId);
        $profile = $this->profileRepository->getById($command->profileId);

        $subscription = $this->userSubscriptionRepository->findByUserAndProfileIds(
            userId: $user->getId(),
            profileId: $profile->getId()
        );

        if (null === $subscription) {
            return;
        }

        $subscription->unsubscribe();

        $this->flusher->flush();
    }
}
