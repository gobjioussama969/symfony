<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    //Search Event by Name
    public function searchByName(string $keyword): array
    {
        $entityManager = $this->getEntityManager();

        $dql = "
            SELECT e
            FROM App\Entity\Event e
            WHERE e.name LIKE :keyword
            ORDER BY e.name ASC
        ";

        return $entityManager->createQuery($dql)
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getResult();
    }

    //Search Events by Category (TO DO) :
    //returns the list of events having $nameCategory as a category
    public function searchByCategory(string $nameCategory): array
    {
        $entityManager = $this->getEntityManager();

        $dql = "
            SELECT e
            FROM App\Entity\Event e
            JOIN e.category c
            WHERE c.name LIKE :nameCategory
            ORDER BY e.name ASC
        ";

        return $entityManager->createQuery($dql)
            ->setParameter('nameCategory', '%' . $nameCategory . '%')
            ->getResult();
    }
}
