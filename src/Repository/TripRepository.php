<?php

namespace App\Repository;

use App\Entity\Trip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trip>
 *
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    public function add(Trip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function checkTripExistsByOrderId(int $orderId)
    {
        return $this->createQueryBuilder('t')
            ->where('t.orderId = :orderId')
            ->setParameter('orderId', $orderId)
            ->getQuery()->getOneOrNullResult();
    }

    public function createTrip(Trip $trip): Trip {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($trip);
        $entityManager->flush();

        return $trip;
    }

    public function indexTripsByAdmin()
    {
        return $this->createQueryBuilder('t')
            ->getQuery()->getResult();
    }

    public function getTripByAdmin(int $tripId): ?Trip
    {
        return $this->createQueryBuilder('t')
            ->where('t.id = :tripId')
            ->setParameter('tripId', $tripId)
            ->getQuery()->getOneOrNullResult();
    }
//    /**
//     * @return Trip[] Returns an array of Trip objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Trip
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
