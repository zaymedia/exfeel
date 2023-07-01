<?php

declare(strict_types=1);

namespace App\Modules\System\Entity\Proxy;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class ProxyRepository
{
    /** @var EntityRepository<Proxy> */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Proxy::class);
        $this->em = $em;
    }

    public function findById(int $id): ?Proxy
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function add(Proxy $proxy): void
    {
        $this->em->persist($proxy);
    }

    public function remove(Proxy $proxy): void
    {
        $this->em->remove($proxy);
    }
}
