<?php

namespace App\Datapersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

final class ProfilDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    public function __construct(EntityManagerInterface $manager, UserRepository $user)
    {
        $this->manager=$manager;
        $this->userRepository = $user;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Profil;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibelle($data->getLibelle());
        $this->manager->persist($data);
        $this->manager->flush();
        // call your persistence layer to save $data
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setArchive(false);
        $id = $data->getId();
        $users = $this->userRepository->findBy(['profil'=>$id]);
        foreach($users as $user){
            $user->setStatut(true);
            $this->manager->persist($user);
            $this->manager->flush();
        }
        $this->manager->persist($data);
        $this->manager->flush();
        return $data;
    }
}
