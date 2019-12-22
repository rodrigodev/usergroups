<?php

namespace App\Application\Service;

use App\Application\Request\Horse\HorseRequestHandler;
use App\Application\Request\Horse\HorseRequest;
use App\Domain\Model\Horse;
use App\Infrastructure\Repository\HorseRepository;
use Doctrine\ORM\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

/**
 * Class HorseService
 * @package App\Application\Service
 */
final class HorseService
{
    /**
     * @var HorseRepository
     */
    private $horseRepository;

    /**
     * @var HorseRequestHandler
     */
    private $horseRequestHandler;
    /**
     * HorseService constructor.
     * @param HorseRepository $horseRepository
     * @param HorseRequestHandler $horseRequestHandler
     */
    public function __construct(
        HorseRepository $horseRepository,
        HorseRequestHandler $horseRequestHandler
    ){
        $this->horseRepository = $horseRepository;
        $this->horseRequestHandler = $horseRequestHandler;
    }

    /**
     * @param string $horseUuid
     * @return Horse
     * @throws EntityNotFoundException
     */
    public function getHorse(string $horseUuid): Horse
    {
        return $this->horseRepository->findOneByEncodedUuid($horseUuid);
    }

    /**
     * @return array|null
     */
    public function getAllHorses(): ?array
    {
        return $this->horseRepository->findAll();
    }

    /**
     * @param HorseRequest $horseRequest
     * @return Horse
     */
    public function addHorse(HorseRequest $horseRequest): Horse
    {
        $horse = $this->horseRequestHandler->createHorse($horseRequest);
        $this->horseRepository->save($horse);
        return $horse;
    }

    /**
     * @param string $horseUuid
     * @param HorseRequest $horseRequest
     * @return Horse|null
     * @throws EntityNotFoundException
     * @throws \Exception
     */
    public function updateHorse(string $horseUuid, HorseRequest $horseRequest): ?Horse
    {
        $horse = $this->horseRepository->findOneByEncodedUuid($horseUuid);
        $horse = $this->horseRequestHandler->updateHorse($horse, $horseRequest);
        $this->horseRepository->save($horse);

        return $horse;
    }

    /**
     * @param string $horseUuid
     * @throws EntityNotFoundException
     */
    public function deleteHorse(string $horseUuid): void
    {
        $horse = $this->horseRepository->findOneByEncodedUuid($horseUuid);
        $this->horseRepository->delete($horse);
    }

    /**
     * @param Horse $horse
     */
    public function save(Horse $horse): void {
        $this->horseRepository->save($horse);
    }
}