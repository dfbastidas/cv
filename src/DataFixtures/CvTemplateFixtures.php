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
        $hollyDommy->setPageWidth('160mm');
        $hollyDommy->setPageHeight('227mm');

        $hollyMommy = new CvTemplate();
        $hollyMommy->setThumbnail('Captura-de-Pantalla-2025-03-13-a-la-s-10-48-31-a-m-67d2fe65111f7.png');
        $hollyMommy->setName('Holly Mommy');
        $hollyMommy->setHtml(file_get_contents(__DIR__ . '/../../templates/fixtures/holly_mommy.html.twig'));
        $hollyMommy->setPageWidth('160mm');
        $hollyMommy->setPageHeight('227mm');


        $grayIsLife = new CvTemplate();
        $grayIsLife->setThumbnail('Captura-de-Pantalla-2025-03-17-a-la-s-2-07-55-p-m-67d8737073394.png');
        $grayIsLife->setName('Gray Is Life');
        $grayIsLife->setHtml(file_get_contents(__DIR__ . '/../../templates/fixtures/gray_is_life.html.twig'));
        $grayIsLife->setPageWidth('180mm');
        $grayIsLife->setPageHeight('235mm');

        $manager->persist($hollyDommy);
        $manager->persist($hollyMommy);
        $manager->persist($grayIsLife);
        $manager->flush();
    }
}