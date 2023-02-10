<?php

namespace App\Repository;

use App\Entity\Beers;
use App\Entity\Breweries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Beers>
 *
 * @method Beers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beers[]    findAll()
 * @method Beers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beers::class);
    }

    public function insert(array $data, int $lastId, int $lastBreweryId): void
    {
        $beer = new Beers;
        $brewery = $this
        ->getEntityManager()
        ->getRepository(Breweries::class)
        ->find($lastBreweryId - 1);
        $beer
            ->setId($lastId + 1)
            ->setName($data['name'])
            ->setStyle($data['style'])
            ->setAbv($data['abv'])
            ->setIbu($data['ibu'])
            ->setOunces($data['ounces'])
            ->setBreweryId($brewery);
        $this->save($beer, true);
    }

    public function save(Beers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Beers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Beers[] Returns an array of Beers objects
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

//    public function findOneBySomeField($value): ?Beers
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
