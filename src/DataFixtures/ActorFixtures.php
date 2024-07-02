<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actor = new Actor();
        $actor->setName("Robert D");
        $manager->persist($actor);

        $actor2 = new Actor();
        $actor2->setName("Tom Hanks");
        $manager->persist($actor2);

        $actor3 = new Actor();
        $actor3->setName("Leonardo DiC ");
        $manager->persist($actor3);

        $manager->flush();
        $this->addReference("actor1", $actor);
        $this->addReference("actor2", $actor2);
        $this->addReference("actor3", $actor3);

    }
}
