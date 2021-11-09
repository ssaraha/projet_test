<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

use App\Data\SearchData;


/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry,  PaginatorInterface $paginator)
    {
        parent::__construct($registry, Article::class);
        $this->paginator = $paginator;
    }

    public function listArticles()
    {
        $query = $this->createQuerybuilder('a')
                      ->select('a')
                      ->getQuery();

        return $this->paginator->paginate(
                    $query,
                    1,
                    3
                );

    }

    public function findSearch(SearchData $searchData)
    {
        $query = $this->createQuerybuilder('a')
                      ->select('a', 't')
                      ->join('a.typeArticle', 't');
        if ( !empty($searchData->q) ) {
            $query = $query->andWhere('a.designation LIKE :q')
                           ->setParameter('q', "%{$searchData->q}%");
        }

        if ( !empty($searchData->min_price) ) {
            $query = $query->andWhere('a.unit_price >= :minPrice')
                           ->setParameter('minPrice', $searchData->min_price);
        }

        if ( !empty($searchData->max_price) ) {
            $query = $query->andWhere('a.unit_price <= :maxPrice')
                           ->setParameter('maxPrice', $searchData->max_price);
        }

        if ( !empty($searchData->promo) ) {
            $query = $query->andWhere('a.isPromo = 1');
        }

        if ( !empty($searchData->categories) ) {
            $query = $query->andWhere('a.typeArticle IN (:typeArticle)')
                           ->setParameter('typeArticle', $searchData->categories);
        }

        $query = $query->orderBy('a.created_at', 'DESC');

        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
