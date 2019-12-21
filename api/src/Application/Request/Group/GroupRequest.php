<?php

namespace App\Application\Request\Group;

/**
 * Class GroupRequest
 * @package App\Application\Request\Group
 */
final class GroupRequest
{

    /**
     * @var string
     */
    private $name;

    /**
     * GroupRequest constructor.
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
