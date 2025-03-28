<?php

namespace App\Repository;

use App\Entity\CurriculumVitae;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CurriculumVitae>
 */
class CurriculumVitaeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurriculumVitae::class);
    }

    public function getUserCurriculums($owner) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT cv.cv_template_id
                FROM App\Entity\CurriculumVitae cv
                WHERE cv.owner =:owner
                ORDER BY cv.id DESC
            ')
            ->setParameter('owner', $owner)
            ->getSingleColumnResult();
    }

}
