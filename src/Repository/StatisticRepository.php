<?php

namespace App\Repository;

use App\Entity\Beer;
use App\Entity\Statistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Statistic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statistic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statistic[]    findAll()
 * @method Statistic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statistic::class);
    }

    public function checkIfAlreadyScored($idBeer, $idClient) {
        return $this->createQueryBuilder('s')
            ->andWhere('s.beer = :idBeer')
            ->andWhere('s.client = :idClient')
            ->setParameter('idBeer', $idBeer)
            ->setParameter('idClient', $idClient)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
