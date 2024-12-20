<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function paginateUser(int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('u')
            ->setFirstResult(($page - 1) * $limit)  // Définir le point de départ de la pagination
            ->setMaxResults($limit)  // Définir la limite de résultats par page
            ->orderBy('u.id', 'ASC')  // Trier par ID
            ->getQuery();
        
        return new Paginator($query);  // Retourner la pagination
    }

    // Méthode pour rechercher des utilisateurs en fonction des critères directement passés dans la méthode
    public function findUserBy(array $criteria, int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('u');

        // Recherche par email
        if (!empty($criteria['email'])) {
            $query->andWhere('u.email = :email')
                ->setParameter('email', $criteria['email']);
        }

        // Pagination et tri
        $query->orderBy('u.id', 'ASC')
            ->setFirstResult(($page - 1) * $limit)  // Définir la pagination
            ->setMaxResults($limit)  // Limiter le nombre de résultats
            ->getQuery()
            ->getResult();  // Exécuter la requête et obtenir les résultats

        return new Paginator($query);  // Retourner la pagination
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
