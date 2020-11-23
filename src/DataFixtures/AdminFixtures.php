<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture implements DependentFixtureInterface
{

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i<=3; $i++){
            $user = new Admin();
            $profil = $this->getReference(ProfilFixtures::ADMIN_USER_REFERENCE);
            $user->setProfil($profil)
                ->setPrenom($faker->firstName)
                ->setNom($faker->lastName)
                ->setUsername($faker->userName)
                ->setEmail($faker->Email)
                ->setTelephone($faker->phoneNumber)
                ->setAdresse($faker->address)
                ->setStatut("actif")
                ->setPhoto("image");

            $password = $this->encoder->encodePassword($user,'pass12345');
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }



    }
    public function getDependencies()
    {
        return array(
            ProfilFixtures::class
        );
    }





}
