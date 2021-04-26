<?php

namespace App\Repository;

use App\Entity\Information;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Information|null find($id, $lockMode = null, $lockVersion = null)
 * @method Information|null findOneBy(array $criteria, array $orderBy = null)
 * @method Information[]    findAll()
 * @method Information[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Information::class);
    }

    /**
     * @param DateTime $dateTime
     * @return Information[]
     */
    public function nearExpireV2(DateTime $dateTime)
    {
        return $this->createQueryBuilder('i')
            ->select('i.id, i.society, i.domain, i.provider_society, i.provider_domain, i.valide_date, i.expire_date, DATE_DIFF(i.expire_date, :date) as expiration')
            ->setParameter('date', $dateTime)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return int|mixed|string
     */
    public function nearExpire()
    {
        return $this->createQueryBuilder('i')
            //->select('d.expire_date')
            ->select('DATE_DIFF(i.expire_date, :date)')
            ->setParameter('date', DateTime::createFromFormat('Y-m-d H:i:s', '2021-03-25 13:00:00'))
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Information[] Returns an array of Information objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Information
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
