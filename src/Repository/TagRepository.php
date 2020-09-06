<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Tag[]    findMostUsedTags()
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    // /**
    //  * @return Tag[] Returns an array of Tag objects
    //  */

    public function findMostUsedTags()
    {

        return $this->createQueryBuilder('tag')
            ->leftJoin('tag.product', 'product')
            ->addSelect('COUNT(product.id) as cnt')
            ->groupBy('tag.id')
            ->orderBy('cnt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->execute();
    }

    /**
     * @return Product[]
     */
    public function findByTag($query)
    {



        $result = $this->createQueryBuilder('tag')
            ->leftJoin('tag.product', 'product')
            ->addSelect('product')
            ->where('tag.name LIKE :query')

            ->setParameter('query', "%" . $query . "%")
            ->getQuery()
            ->getResult();
        $products = [];
        foreach ($result as $tag) {
            foreach ($tag->getProduct() as $product) {
             
                array_push($products, $product);
            }
        }
        return $products;
    }
    // /**
    //  * @return Tag[] Returns an array of Tag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneByName($value): ?Tag
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
