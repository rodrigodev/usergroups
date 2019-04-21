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
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->name = $title;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
