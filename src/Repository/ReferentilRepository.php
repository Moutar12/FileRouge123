<?php

namespace App\Repository;

use App\Entity\Referentil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Referentil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Referentil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Referentil[]    findAll()
 * @method Referentil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferentilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Referentil::class);
    }

    // /**
    //  * @return Referentil[] Returns an array of Referentil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Referentil
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
