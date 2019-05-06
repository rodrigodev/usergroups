<?php

namespace App\Application\DTO\Group;

/**
 * Class GroupDTO
 * @package App\Application\Group\DTO
 */
final class GroupDTO
{

    /**
     * @var string
     */
    private $name;

    /**
     * GroupDTO constructor.
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
