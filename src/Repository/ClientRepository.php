<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

        public function paginateClient(int $page, int $limit): Paginator
        {
            $query = $this->createQueryBuilder('c')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit) 
                ->orderBy('c.id', 'ASC') 
                ->getQuery();
            return new Paginator($query);
        }

        public function findClientBy(ClientSearchDto $clientSearchDto ,int $page, int $limit): Paginator
        {
            $query = $this->createQueryBuilder('c');
            if (!empty($clientSearchDto->telephone)) {
                $query->andWhere('c.telephone = :telephone')
                        ->setParameter('telephone', $clientSearchDto->telephone); 
            }
            if (!empty($clientSearchDto->prenom)) {
                $query->andWhere('c.prenom = :prenom')
                        ->setParameter('prenom', $clientSearchDto->prenom); 
            }
            $query->orderBy('c.id', 'ASC')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit) 
                ->getQuery()
                ->getResult()
               ;
            return new Paginator($query);

        }


    //    /**
    //     * @return Client[] Returns an array of Client objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Client
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
