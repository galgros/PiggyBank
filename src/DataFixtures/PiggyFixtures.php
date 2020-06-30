<?php

namespace App\DataFixtures;

use App\Entity\PiggyBank;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PiggyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $piggy = new PiggyBank();
        $piggy->setBalance(0);
        $manager->persist($piggy);

        $manager->flush();
    }
}
