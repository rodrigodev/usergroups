<?php

namespace App\Application\Request\Horse;

use App\Domain\Model\Horse;
use Ramsey\Uuid\Uuid;

/**
 * Class HorseRequestHandler
 * @package App\Application\Request
 */
final class HorseRequestHandler
{

    /**
     * @param HorseRequest $horseRequest
     * @param Horse|null $horse
     * @return Horse
     * @throws \Exception
     */
    public function fromRequest(HorseRequest $horseRequest, ?Horse $horse = null): Horse
    {
        if (!$horse) {
            $horse = new Horse(Uuid::uuid4());
        }

        $horse->setName($horseRequest->getName());
        $horse->setPicture($horseRequest->getPicture());

        return $horse;
    }

    /**
     * @param Horse $horse
     * @param HorseRequest $horseRequest
     * @return Horse
     * @throws \Exception
     */
    public function updateHorse(Horse $horse, HorseRequest $horseRequest): Horse
    {
        return $this->fromRequest($horseRequest, $horse);
    }

    /**
     * @param HorseRequest $horseRequest
     * @return Horse
     * @throws \Exception
     */
    public function createHorse(HorseRequest $horseRequest): Horse
    {
        return $this->fromRequest($horseRequest);
    }

    /**
     * @param Horse $horse
     * @return HorseRequest
     */
    public function toRequest(Horse $horse): HorseRequest
    {
        return new HorseRequest(
            $horse->getName(),
            $horse->getPicture()
        );
    }

}
