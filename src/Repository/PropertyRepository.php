<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Property[]    findAllVisible()
 * @method Property[]    findNoSold()
 * @method Property[]    findLatestSix()
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function add(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Property[]
     */
    public function findAllVisible(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Property[]
    //  */
    // public function findNoSold(): array
    // {
    //     return $this->createQueryBuilder('p')
    //         ->where('p.sold = false')
    //         ->getQuery()
    //         ->getResult();
    // }

    /*
    *
    * @param type $champ
    * @param type $valeur
    * @return Property[]
    */
    public function findAllOrderBy($champ, $ordre): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false')
            ->orderBy('p.' . $champ, $ordre)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param type $champs
     * @param type $ordre
     * @return Property[]
     */
    public function findLatestSix($champ, $ordre): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false')
            ->orderBy('p.' . $champ, $ordre)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /*
    *
    * @param type $champ
    * @param type $valeur
    * @return Property[]
    */
    public function findByEqualValue($champ, $valeur): array
    {
        if ($valeur == "") {
            return $this->createQueryBuilder('p')
                ->orderBy('p.' . $champ, 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('p')
                ->where('p.' . $champ . '=:valeur')
                ->setParameter('valeur', $valeur)
                ->orderBy('p.created_at', 'DESC')
                ->getQuery()
                ->getResult();
        }
    }

    /*
    *
    * @param type $champ
    * @param type $valeur
    * @return Property[]
    */
    public function findByPrice($champ, $valeur): array
    {
        if ($valeur == "") {
            return $this->createQueryBuilder('p')
                ->orderBy('p.' . $champ, 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('p')
                ->where('p.' . $champ . ':=valeur')
                ->setParameter('valeur', $valeur)
                ->orderBy('p.price', 'DESC')
                ->getQuery()
                ->getResult();
        }
    }


    //    /**
    //     * @return Property[] Returns an array of Property objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Property
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
