<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findDisplayable()
    {
        return $this->findBy(['deletedAt'=>null, 'enable'=>true]);
    }

    public function add(Product $product): void {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush($product);
    }

    public function delete(Product $product): void {
        $product->setDeletedAt(new \DateTime());
        $this->getEntityManager()->flush($product);
    }

    public function countDisplayable()
    {
        return $this->count(['deletedAt'=>null, 'enable'=>true]);
    }

    public function createPaginatorForDisplayableProducts(int $offset, int $limit): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.enable = :enable')
            ->andWhere('p.deletedAt IS NULL')
            ->setParameter('enable', true)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
        ;
        return  new Paginator($queryBuilder->getQuery());
    }
}
