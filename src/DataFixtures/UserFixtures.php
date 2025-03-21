<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture {

    private UserPasswordHasherInterface $hasher;

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('diegofernando150@gmail.com');
        $user->setMainProfession('Full Stack Developer');
        $user->setName('Diego Fernando');
        $user->setLastName('Bastidas Rincón');
        $user->setPhoto('DFBASTIDAS-66a17dd04e889-66a2633e1a284-67d43a60d8c80.jpg');
        $user->setAboutMe('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis condimentum nibh quis mauris consequat, eu rutrum mi molestie. Mauris enim turpis, tincidunt at erat at, fringilla congue eros. Mauris commodo libero ut elit hendrerit congue.');
        $user->setMainEmail('diegofernando150@gmail.com');
        $user->setMainPhone('3045711812');
        $user->setLocation('Palmira, Colombia');
        $password = $this->hasher->hashPassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();

        $this->addReference('user', $user);
    }
}