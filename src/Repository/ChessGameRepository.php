<?php

namespace App\Repository;

use App\Entity\ChessGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ChessGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChessGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChessGame[]    findAll()
 * @method ChessGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChessGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChessGame::class);
    }

    // /**
    //  * @return ChessGame[] Returns an array of ChessGame objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChessGame
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
