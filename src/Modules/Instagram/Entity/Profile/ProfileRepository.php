<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Entity\Profile;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class ProfileRepository
{
    /**
     * @var EntityRepository<Profile>
     */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Profile::class);
        $this->em = $em;
    }

    public function findById(int $id): ?Profile
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function findByUserId(int $userId): ?Profile
    {
        return $this->repo->findOneBy(['userId' => $userId]);
    }

    public function add(Profile $profile): void
    {
        $this->em->persist($profile);
    }

    public function remove(Profile $profile): void
    {
        $this->em->remove($profile);
    }
}
