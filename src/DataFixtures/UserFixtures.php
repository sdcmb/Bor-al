<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Panier;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $bernard = new User();
        $tony = new User();
        $gerard = new User();
        $severine = new User();

        $bernard->setEmail("bernard.tapis@gmail.com")
            ->setLastname("Tapis")
            ->setFirstname("Bernard")
            ->setPassword('$2y$13$xjs2IU7Wuz7sasRgD3SxzOcnKQeaIGYogQa8SFbEdHnbookg3BHjO'); //BernardTapis

        $tony->setEmail("tony.montana@gmail.com")
            ->setLastname("Montana")
            ->setFirstname("Tony")
            ->setPassword('$2y$13$qspWl/W0kSHRS3fNXWJXqun.utNW8mR/Mu9npJBoeioGLpGHhK0E2'); //SayHello2MyLittleFriend


        $gerard->setEmail("gerard.2par2@gmail.com")
            ->setLastname("Deuxpardeux")
            ->setFirstname("Gérard")
            ->setPassword('$2y$13$sgzTB77abmJWHy9hNuWtFuDujOinFBapwcovG0D6JS5mo0BWgwqY2'); //Gerard2par2

        $severine->setEmail("boreal@gmail.com")
            ->setLastname("Praud")
            ->setFirstname("Severine")
            ->setPassword('$2y$13$MXAIXQDGYP6nxjeGCDui7OaZpXU0q6VWMdyKwupMjTBLaQ2xVcOpO') //borealMaroquinerie
            ->addRole('ROLE_ADMIN');

        $manager->persist($bernard);
        $manager->persist($tony);
        $manager->persist($gerard);
        $manager->persist($severine);

        $manager->flush();

    }
}
