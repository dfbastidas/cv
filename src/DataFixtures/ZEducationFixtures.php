<?php

namespace App\DataFixtures;

use App\Entity\Education;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZEducationFixtures extends  Fixture{
    public function load(ObjectManager $manager): void {
        $system = new Education('Ing en sistemas', new \DateTime(), new \DateTime(), 'Universidad del Valle');
        $devOps = new Education('Ing DevOps', new \DateTime(), new \DateTime(), 'Mundos E');

        $system->setUser($this->getReference('user', User::class));
        $devOps->setUser($this->getReference('user', User::class));

        $manager->persist($system);
        $manager->persist($devOps);

        $manager->flush();
    }
}