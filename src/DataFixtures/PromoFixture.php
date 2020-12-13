<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Profil;
use App\Entity\Promo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PromoFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $promo = ["promo1","promo2","promo3"];
        foreach ($promo as $key => $libelle){
            if ($libelle == "promo1"){
                $promos = new Promo();
                $promos->setNomPromo($libelle)
                    ->setDateDebut(new \DateTime("2010-12-16"))
                    ->setDateFin(new \DateTime("2014-12-16"));
                $manager->persist($promos);
                $manager->flush();

                $groupes =["groupe1","groupe2","groupe3"];
                foreach ($groupes as $key => $libelles){
                    if($libelles == "groupe1"){
                        $groupe = new Groupe();
                        $groupe->setNomGroupe($libelles)
                            ->setPromo($promos)
                            ->setStatut('principal');
                    }else{
                        $groupe->setNomGroupe($libelles)
                            ->setPromo($promos);
                        $manager->persist($groupe);
                    }

                    $manager->flush();
                }



            }
        }

        $manager->flush();
    }
}
