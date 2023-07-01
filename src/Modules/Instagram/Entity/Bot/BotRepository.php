<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Entity\Bot;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class BotRepository
{
    /** @var EntityRepository<Bot> */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Bot::class);
        $this->em = $em;
    }

    public function findById(int $id): ?Bot
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function add(Bot $bot): void
    {
        $this->em->persist($bot);
    }

    public function remove(Bot $bot): void
    {
        $this->em->remove($bot);
    }
}
