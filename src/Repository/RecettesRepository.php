<?php

namespace App\Repository;

use App\Entity\Recettes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Recettes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recettes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recettes[]    findAll()
 * @method Recettes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecettesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recettes::class);
    }

    
    /**
     * @return Recettes[] //Retourne un tableau Recettes dans le RecettesController (ici : un seul élément avec "where r.id")
     */
    public function findRecettes () : array
    {
        return $this->findAllQuery()
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @return Recettes[]
     */
    public function findLatest() : array
    {
        return $this->findAllQuery() //Utilisation de la fonction privée au dessus  
                    ->setMaxResults(20)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @return QueryBuider //Retourne un tableau Recettes dans le RecettesController 
     */
    private function findAllQuery() : QueryBuilder
    {
        return $this->createQueryBuilder("r")
                    ->where("r.id >= 0");
    }

    // /**
    //  * @return Recettes[] Returns an array of Recettes objects
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
    public function findOneBySomeField($value): ?Recettes
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
