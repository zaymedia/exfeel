<?php

declare(strict_types=1);

namespace App\Modules\User\Entity\UserSubscription;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class UserSubscriptionRepository
{
    /** @var EntityRepository<UserSubscription> */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(UserSubscription::class);
        $this->em = $em;
    }

    public function findById(int $id): ?UserSubscription
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function add(UserSubscription $userSubscription): void
    {
        $this->em->persist($userSubscription);
    }

    public function remove(UserSubscription $userSubscription): void
    {
        $this->em->remove($userSubscription);
    }
}
