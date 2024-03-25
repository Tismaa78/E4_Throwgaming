<?php

namespace App\Repository;

use App\Entity\Jeu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @extends ServiceEntityRepository<Jeu>
 *
 * @method Jeu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jeu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jeu[]    findAll()
 * @method Jeu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jeu::class);
    }

   /**
    * @return Jeu[] Returns an array of Jeu objects
    */
   public function findByGenre(string $value): array
   {
       return $this->createQueryBuilder('j')
           ->select('j', 'g')
           ->leftJoin('j.genre','g')
           ->andWhere('g.libelle = :val')
           ->setParameter('val', $value)
           ->orderBy('j.titre','ASC')
           ->getQuery()
           ->getResult()
       ;
   }
   
   public function findByGenreP(string $value): Query
   {
       return $this->createQueryBuilder('j')
           ->select('j', 'g')
           ->leftJoin('j.genre','g')
           ->andWhere('g.libelle = :val')
           ->setParameter('val', $value)
           ->orderBy('j.titre','ASC')
           ->getQuery()
       ;
   }

   /**
    * @return Jeu[] Returns game count
    */
   public function countAll(): array
   {
       return $this->createQueryBuilder('j')
           ->select('COUNT(j)')
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return Query Returns query
    */
   public function listePagine(): Query
   {
       return $this->createQueryBuilder('j')
           ->select('j')
           ->distinct()
           ->orderBy('j.titre', 'ASC')
           ->getQuery()
       ;
   }

//    /**
//     * @return Jeu[] Returns an array of Jeu objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Jeu
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
