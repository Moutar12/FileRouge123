<?php


namespace App\DataFixtures;


use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ProfilFixtures extends  Fixture
{
    public const ADMIN_USER_REFERENCE = 'ADMIN';
    public const FORMATEUR_USER_REFERENCE = 'FORMATEUR';
    public const CM_USER_REFERENCE = 'CM';
    public const APPRENANT_USER_REFERENCE = 'APPRENANT';
    public function load(ObjectManager $manager)
    {

        $profil = ["ADMIN", "FORMATEUR", "CM", "APPRENANT"];
        foreach ($profil as $key => $libelle){
            $profil = new Profil();
            $profil->setLibelle($libelle);
            $profil->setArchive(true);
            if($libelle == "ADMIN"){
                $this->addReference(self::ADMIN_USER_REFERENCE, $profil);
            }elseif ($libelle == "FORMATEUR"){
                $this->addReference(self::FORMATEUR_USER_REFERENCE, $profil);
            }elseif ($libelle == "CM"){
                $this->addReference(self::CM_USER_REFERENCE, $profil);
            }elseif ($libelle == "APPRENANT"){
                $this->addReference(self::APPRENANT_USER_REFERENCE, $profil);
            }
            $manager->persist($profil);
            $manager->flush();
        }

    }
}
