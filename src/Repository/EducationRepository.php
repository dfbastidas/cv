<?php

namespace App\Repository;

use App\Entity\Education;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Education>
 */
class EducationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Education::class);
    }

    public function getUserEducation($user) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT education
                FROM App\Entity\Education education
                JOIN education.user user
                WHERE user.id =:user
                ORDER BY user.id DESC
            ')->setParameter('user', $user)
            ->getArrayResult();
    }
}
