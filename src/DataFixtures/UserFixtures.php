<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $bernard = new User();
        $tony = new User();
        $gerard = new User();

        $bernard->setEmail("bernard.tapis@gmail.com")
            ->setLastname("Tapis")
            ->setFirstname("Bernard")
            ->setPassword('$2y$13$xjs2IU7Wuz7sasRgD3SxzOcnKQeaIGYogQa8SFbEdHnbookg3BHjO'); //BernardTapis



        $tony->setEmail("tony.montana@gmail.com")
            ->setLastname("Montana")
            ->setFirstname("Tony")
            ->setPassword('$2y$13$xjs2IU7Wuz7sasRgD3SxzOcnKQeaIGYogQa8SFbEdHnbookg3BHjO'); //SayHello2MyLittleFriend

        $gerard->setEmail("gerard.2par2@gmail.com")
            ->setLastname("Deuxpardeux")
            ->setFirstname("Gérard")
            ->setPassword('$2y$13$xjs2IU7Wuz7sasRgD3SxzOcnKQeaIGYogQa8SFbEdHnbookg3BHjO'); //Gerard2par2

        $manager->persist($bernard);
        $manager->persist($tony);
        $manager->persist($gerard);

        $manager->flush();
    }
}
