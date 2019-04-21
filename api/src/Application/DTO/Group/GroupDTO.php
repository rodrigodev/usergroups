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
