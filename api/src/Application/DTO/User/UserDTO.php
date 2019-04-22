<?php

namespace App\Application\DTO\User;

/**
 * Class UserDTO
 * @package App\Application\User\DTO
 */
final class UserDTO
{

    /**
     * @var string
     */
    private $name;

    /**
     * UserDTO constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
