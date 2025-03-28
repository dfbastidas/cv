<?php

namespace App\Repository;

use App\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Link>
 */
class LinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    public function getUserLink($user) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT link
                FROM App\Entity\Link link
                JOIN link.user user
                WHERE user.id =:user
                ORDER BY user.id DESC
            ')->setParameter('user', $user)
            ->getArrayResult();
    }

}
