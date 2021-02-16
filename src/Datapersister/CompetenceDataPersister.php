<?php

namespace App\Datapersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Competence;
use Doctrine\ORM\EntityManagerInterface;

final class CompetenceDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager=$manager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Competence;
    }

    public function persist($data, array $context = [])
    {
        
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setStatus(true);
        $this->manager->flush();
        return $data;
    }
}
