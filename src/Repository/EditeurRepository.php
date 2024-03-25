<?php

namespace App\Repository;

use App\Entity\Editeur;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Editeur>
 *
 * @method Editeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Editeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Editeur[]    findAll()
 * @method Editeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Editeur::class);
    }

//    /**
//     * @return Editeur[] Returns an array of Editeur objects
//     */
//    public function findByExampleField($value): ?Query 
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//        ;
//    }

//    public function findOneBySomeField($value): ?Editeur
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
