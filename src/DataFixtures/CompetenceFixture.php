<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompetenceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $competences = ["competence1","competence2","competence3","competence4"];
        foreach ($competences as $key => $libelle){
        $competence = new Competence();
        $competence->setLibelle($libelle);
        $manager->persist($competence);

    }


        $manager->flush();
    }
}
