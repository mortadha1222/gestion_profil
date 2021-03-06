<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Reclamation objects
    //  */

    public function findBySearch($value)
    {
        return $this->createQueryBuilder('c')
            ->orWhere('c.idCommande Like :val')
            ->orWhere('c.userName Like :val')
            ->orWhere('c.adresseLivraison Like :val')
            ->orWhere('c.total LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('c.idCommande', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
    /*
    public function countRecDate()
    {
        return $this->createQueryBuilder('r')
            ->select('r.date as dates , COUNT(r) as count')
            ->groupBy('dates')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findOneBySomeField($value): ?Reclamation
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