<?php

namespace App\Repository;

use App\Entity\SaleDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SaleDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaleDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaleDetail[]    findAll()
 * @method SaleDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaleDetail::class);
    }

    // /**
    //  * @return SaleDetail[] Returns an array of SaleDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SaleDetail
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
