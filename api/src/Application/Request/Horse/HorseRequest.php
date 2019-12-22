<?php

namespace App\Application\Request\Horse;

/**
 * Class HorseRequest
 * @package App\Application\Request\Horse
 */
final class HorseRequest
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $picture;

    /**
     * HorseRequest constructor.
     * @param string $name
     * @param string $picture
     */
    public function __construct(string $name, string $picture)
    {
        $this->name = $name;
        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

}
