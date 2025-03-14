<?php
namespace App\DataFixtures;

use App\Entity\CvTemplate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CvTemplateFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $hollyDommy = new CvTemplate();
        $hollyDommy->setThumbnail('Captura-de-Pantalla-2025-03-12-a-la-s-2-59-12-p-m-67d32e7bd84d2.png');
        $hollyDommy->setName('holly dommy');
        $hollyDommy->setHtml(file_get_contents(__DIR__ . '/../../templates/fixtures/holly_dommy.html.twig'));

        $hollyMommy = new CvTemplate();
        $hollyMommy->setThumbnail('Captura-de-Pantalla-2025-03-13-a-la-s-10-48-31-a-m-67d2fe65111f7.png');
        $hollyMommy->setName('Holly Mommy');
        $hollyMommy->setHtml(file_get_contents(__DIR__ . '/../../templates/fixtures/holly_mommy.html.twig'));

        $manager->persist($hollyDommy);
        $manager->persist($hollyMommy);
        $manager->flush();
    }
}