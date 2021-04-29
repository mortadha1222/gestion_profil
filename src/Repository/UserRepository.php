<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }



     /**
      * @return User[] Returns an array of User objects
      */

   public function findAllPublishedOrderedByNewest()
    {

        return $this->createQueryBuilder('a')
            ->andWhere('a.username IS NOT NULL')
            ->orderBy('a.username', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findBySearch($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

/*    public function countusers()
    {
      return $this->createQueryBuilder('a')
            ->select('count(a.idUser)')
            ->getQuery()
            ->getSingleScalarResult();

    }*/

    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findUserByUsername($username){
        return $this->createQueryBuilder('user')
            ->where('user.username LIKE :username')
            ->setParameter('username', '%'.$username.'%')
            ->getQuery()
            ->getResult();
    }



    public function loadUserByUsername($username): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.username = :query '
        )
            ->setParameter('query', $username)
            ->getOneOrNullResult();
    }
    public function loadUserByPassword($password): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.password = :query '
        )
            ->setParameter('query', $password)
            ->getOneOrNullResult();
    }

   /* public function triASC()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.username', 'ASC')
            ->getQuery()
            ->getResult()
            ;

    }*/

}

