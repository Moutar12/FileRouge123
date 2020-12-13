<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NiveauFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $niveau = ["Tres bien", "Assez bien", "Bien","Passable","Mauvais"];

        foreach ($niveau as $key => $libelle){
            $niveaux = new Niveau();
            $niveaux->setLibelle($libelle);
            $manager->persist($niveaux);
        }

        $manager->flush();
    }
}
