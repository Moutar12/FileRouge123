<?php

namespace App\Datapersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

final class UserDatapersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    public function __construct(EntityManagerInterface $manager, UserRepository $user)
    {
        $this->manager=$manager;
        $this->userRepository = $user;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setStatut(false);
        $this->manager->flush();
        return $data;
    }
}
