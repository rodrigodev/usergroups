<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Horse;
use App\Domain\Model\HorseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class HorseRepository
 * @package App\Infrastructure\Repository
 * @method Horse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horse[]    findAll()
 */
class HorseRepository extends ServiceEntityRepository implements HorseRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * HorseRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Horse::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param Horse $horse
     */
    public function save(Horse $horse): void {
        $this->entityManager->persist($horse);
        $this->entityManager->flush();
    }

    /**
     * @param Horse $horse
     */
    public function delete(Horse $horse): void {
        $this->entityManager->remove($horse);
        $this->entityManager->flush();
    }

    /**
     * @param string $uuid
     * @return Horse
     * @throws EntityNotFoundException
     */
    public function findOneByUuid(string $uuid): Horse
    {
        /**
         * @var Horse $horse
         */
        $horse = $this->findOneBy([
            'uuid' => $uuid
        ]);

        if (null === $horse) {
            throw new EntityNotFoundException('invalid horse uuid');
        }

        return $horse;
    }

    /**
     * @return array
     */
    public function getAll(): array {
        return $this->findAll();
    }
}
