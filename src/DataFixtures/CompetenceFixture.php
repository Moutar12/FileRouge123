<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\GroupeCompetence;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompetenceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $niveaux = ['niveau 1', 'niveau 2', 'niveau 3'];
        $groupeCompetences = ["developper le back", "developper le front"];
        $competences = ['Créer une base de données',  'Maquetter une application', 'Réaliser une interface'];

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 2; $i++) {
            $grpComp = new GroupeCompetence();
            //$randomGrpComp = random_int(0,count($groupeCompetences)-1);
            $grpComp->setLibelle($groupeCompetences[$i]);
            $grpComp->setDescription($faker->text);
            $grpComp->setStatut(false);


            for ($j = 0; $j < 5; $j++) {
                $comp = new Competence();

                $randomComp = random_int(0, count($competences) - 1);
                $comp->setLibelle($competences[$randomComp]);
                $comp->setDescription($faker->text);

                $niv = new Niveau();
                $randomNiveau = random_int(0, count($niveaux) - 1);
                $niv->setLibelle($niveaux[$randomNiveau]);
                $comp->addNiveau($niv);
                $grpComp->addCompetence($comp);
                $manager->persist($comp);

           }
            $manager->persist($grpComp);
            $manager->flush();
          }
          }
}
