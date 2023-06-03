<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Entity\Stories;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class StoriesRepository
{
    /**
     * @var EntityRepository<Stories>
     */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Stories::class);
        $this->em = $em;
    }

    public function findById(int $id): ?Stories
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function findByStoryId(string $storyId): ?Stories
    {
        return $this->repo->findOneBy(['storyId' => $storyId]);
    }

    public function add(Stories $stories): void
    {
        $this->em->persist($stories);
    }

    public function remove(Stories $stories): void
    {
        $this->em->remove($stories);
    }
}
