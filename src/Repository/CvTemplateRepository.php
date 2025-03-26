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

    public function getUserTemplateList($template_id_list) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT template
                FROM App\Entity\CvTemplate template
                WHERE template.id IN (:template_id_list)
                ORDER BY template.id DESC
            ')
            ->setParameter('template_id_list', $template_id_list)
            ->getArrayResult();
    }
}
