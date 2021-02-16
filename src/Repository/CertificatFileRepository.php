<?php

namespace App\Repository;

use App\Entity\CertificatFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CertificatFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CertificatFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CertificatFile[]    findAll()
 * @method CertificatFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CertificatFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CertificatFile::class);
    }

    // /**
    //  * @return CertificatFile[] Returns an array of CertificatFile objects
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
    public function findOneBySomeField($value): ?CertificatFile
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
