<?php

namespace App\Repository;

use App\Entity\Experience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Experience>
 */
class ExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Experience::class);
    }

    public function getUserExperience($user) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT experience
                FROM App\Entity\Experience experience
                JOIN experience.user user
                WHERE user.id =:user
                ORDER BY user.id DESC
            ')->setParameter('user', $user)
            ->getArrayResult();
    }

}
