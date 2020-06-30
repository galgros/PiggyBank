<?php

namespace App\Repository;

use App\Entity\PiggyBank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PiggyBank|null find($id, $lockMode = null, $lockVersion = null)
 * @method PiggyBank|null findOneBy(array $criteria, array $orderBy = null)
 * @method PiggyBank[]    findAll()
 * @method PiggyBank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PiggyBankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PiggyBank::class);
    }

    // /**
    //  * @return PiggyBank[] Returns an array of PiggyBank objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PiggyBank
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
