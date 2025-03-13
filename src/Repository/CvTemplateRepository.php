<?php

namespace App\Repository;

use App\Entity\CvTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CvTemplate>
 */
class CvTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CvTemplate::class);
    }

    public function getCvTemplatesList() {
        return $this->getEntityManager()
            ->createQuery('
                SELECT template
                FROM App\Entity\CvTemplate template
                ORDER BY template.id DESC
            ');
    }
}
