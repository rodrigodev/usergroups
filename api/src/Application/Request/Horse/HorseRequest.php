<?php

namespace App\Application\Request\Horse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HorseRequest
 * @package App\Application\Request\Horse
 */
final class HorseRequest
{
    /**
     * @var string
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     * @Assert\Url
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
     * @param Request $request
     * @return HorseRequest
     */
    public static function createFromRequest(Request $request): HorseRequest
    {
        return new self(
            $request->request->get('name'),
            $request->request->get('picture')
        );
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
