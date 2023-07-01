<?php

declare(strict_types=1);

namespace App\Modules\User\Entity\UserView;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class UserViewRepository
{
    /** @var EntityRepository<UserView> */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(UserView::class);
        $this->em = $em;
    }

    public function findById(int $id): ?UserView
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function add(UserView $userView): void
    {
        $this->em->persist($userView);
    }

    public function remove(UserView $userView): void
    {
        $this->em->remove($userView);
    }
}
