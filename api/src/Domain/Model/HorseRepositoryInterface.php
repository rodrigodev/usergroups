<?php


namespace App\Domain\Model;


/**
 * Interface HorseRepositoryInterface
 * @package App\Domain\Model\Horse
 */
interface HorseRepositoryInterface
{
    /**
     * @param string $uuid
     * @return Horse
     */
    public function findOneByUuid(string $uuid) : Horse;

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