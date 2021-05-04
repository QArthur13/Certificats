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
     * @param string $search
     * Permet de chercher des sociéter
     * @return Information[]
     */
    public function searchSociety(DateTime $dateTime, string $search)
    {
        return $this->createQueryBuilder('i')
            ->select('i.id, i.society, i.domain, i.provider_society, i.provider_domain, i.valide_date,
            i.expire_date, DATE_DIFF(i.expire_date, :date) as expiration')
            ->setParameter('date', $dateTime)
            ->andWhere('i.society LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param DateTime $dateTime
     * Permet de récupérer tout les certificats qui sont expirés
     * @return Information[]
     */
    public function expire(DateTime $dateTime)
    {
        return $this->createQueryBuilder('i')
            ->select('i.id, i.society, i.domain, i.provider_society, i.provider_domain, i.valide_date, 
            i.expire_date, u.email, u.lastname, u.firstname, DATE_DIFF(i.expire_date, :date) as expiration')
            ->setParameter('date', $dateTime)
            ->innerJoin('i.user', 'u', 'WITH', 'i.user = u.id')
            ->where('DATE_DIFF(i.expire_date, :date) <= 0')
            ->setParameter('date', $dateTime)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param DateTime $dateTime
     * Permet de récupérer les derniers jours avant l'expiration du certificats
     * @return Information[]
     */
    public function fiveDaysExpire(DateTime $dateTime)
    {
        return $this->createQueryBuilder('i')
            ->select('i.id, i.society, i.domain, i.provider_society, i.provider_domain, i.valide_date, 
            i.expire_date, u.email, u.lastname, u.firstname, DATE_DIFF(i.expire_date, :date) as expiration')
            ->innerJoin('i.user', 'u', 'WITH', 'i.user = u.id')
            ->setParameter('date', $dateTime)
            ->andWhere('DATE_DIFF(i.expire_date, :date) > 0')
            ->setParameter('date', $dateTime)
            ->andWhere('DATE_DIFF(i.expire_date, :date) <= 5')
            ->setParameter('date', $dateTime)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param DateTime $dateTime
     * @return Information[]
     */
    public function nearExpire(DateTime $dateTime)
    {
        return $this->createQueryBuilder('i')
            ->select('i.id, i.society, i.domain, i.provider_society, i.provider_domain, i.valide_date, i.expire_date, DATE_DIFF(i.expire_date, :date) as expiration')
            ->setParameter('date', $dateTime)
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
