<?php


namespace App\Domain\Model;


use Ramsey\Uuid\UuidInterface;

/**
 * Interface HorseRepositoryInterface
 * @package App\Domain\Model\Horse
 */
interface HorseRepositoryInterface
{

    /**
     * @param int $id
     * @return Horse
     */
    public function findById(int $id) : Horse;

    /**
     * @param string $uuid
     * @return Horse
     */
    public function findOneByEncodedUuid(string $uuid) : Horse;

    /**
     * @return array|Horse[]
     */
    public function getAll() : array;

    /**
     * @param Horse $Horse
     */
    public function save(Horse $Horse): void;

    /**
     * @param Horse $Horse
     */
    public function delete(Horse $Horse): void;

}