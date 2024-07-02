<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle("Inception");
        $movie->setDescription("Inception's Description");
        $movie->setYear(2010);
        $movie->setImagePath("https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcSOIx7scfQ2-dckMQsblJySqjGiTJjoDTyaaLB9MVJ6-zTnS_XIoN4U2OGTXK_dqtOtWciZnHBLeHmlOPnVwJqXkLAWZXd4zq08dldeNg");
        $movie->addActor($this->getReference("actor3"));
        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2->setTitle("Avengers");
        $movie2->setDescription("Inception's Description");
        $movie2->setYear(2009);
        $movie2->setImagePath("https://t2.gstatic.com/licensed-image?q=tbn:ANd9GcSK0mRgxk6RD6AXbkAzpQRs7FCh9J0FiOxC9eIHCqoxAgpBeywiPrFjbAcGKbCaVYkc");
        $movie2->addActor($this->getReference("actor2"));
        $movie2->addActor($this->getReference("actor1"));
        $manager->persist($movie2);

        $manager->flush();
    }
}
