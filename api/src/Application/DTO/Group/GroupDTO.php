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
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * GroupDTO constructor.
     * @param string $title
     * @param string $content
     */
    public function __construct(string $title = '', string $content = '')
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

}
