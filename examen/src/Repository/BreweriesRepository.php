<?php

namespace App\Repository;

use App\Entity\Breweries;
use App\Entity\Beers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Breweries>
 *
 * @method Breweries|null find($id, $lockMode = null, $lockVersion = null)
 * @method Breweries|null findOneBy(array $criteria, array $orderBy = null)
 * @method Breweries[]    findAll()
 * @method Breweries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreweriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Breweries::class);
    }

    public function insert(array $data, int $lastId): void
    {
        $brewery = new Breweries;
        $brewery
            ->setId($lastId + 1)
            ->setName($data['name'])
            ->setCity($data['city'])
            ->setState($data['state']);
        $this->save($brewery, true);
    }

    public function save(Breweries $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Breweries $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Breweries[] Returns an array of Breweries objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Breweries
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
