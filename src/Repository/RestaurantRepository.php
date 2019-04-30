<?php

namespace App\Repository;

use App\Entity\Restaurant;
use App\Entity\RestaurantSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query as Query;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Restaurant::class); 
    }
    /**
     * @return Query
     */

    public function findAllVisibleQuery(RestaurantSearch $search) : Query
    {
        $query = $this->findVisibleQuery();
        
        if($search->getMaxPrice()){
            $query = $query
                ->andWhere('p.average_price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
            

        }

        if($search->getMinPlace()){
            $query = $query
                ->andWhere('p.place >= :minplace')
                ->setParameter('minplace', $search->getMinPlace());
        }

        if($search->getOptions()->count() > 0){
            $k = 0;
            foreach($search->getOptions() as $option) {
                $k++;
                $query = $query
                    ->andWhere(":option$k MEMBER OF p.options")
                    ->setParameter("option$k", $option);
            }

        }

        return $query->getQuery();
    }
    
    public function findLatest() : array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.place > 0')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();
    }

    private function findVisibleQuery () : QueryBuilder
    {
        return $this->createQueryBuilder('p')
        ->where('p.place > 0')
        ;
    }

    // /**
    //  * @return Restaurant[] Returns an array of Restaurant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restaurant
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
