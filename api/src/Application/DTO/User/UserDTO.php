<?php

namespace App\Application\DTO\User;

/**
 * Class UserDTO
 * @package App\Application\User\DTO
 */
final class UserDTO
{
    //TODO: Change implementation to json marshalling
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $username;

    /**
     * UserDTO constructor.
     * @param string $name
     * @param string $username
     * @param string $password
     */
    public function __construct(string $name, string $username, string $password)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
