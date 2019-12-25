<?php

namespace App\Application\Request\Group;

use App\Application\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GroupRequest
 * @package App\Application\Request\Group
 */
final class GroupRequest
{
    /**
     * @var string
     * @Assert\NotBlank
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
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return GroupRequest
     * @throws ValidationException
     */
    public static function createFromRequest(Request $request, ValidatorInterface $validator): GroupRequest
    {
        $groupRequest = new self(
            $request->request->get('name')
        );

        $errors = $validator->validate($groupRequest);

        if (count($errors) > 0) {
            throw new ValidationException((string) $errors);
        }

        return $groupRequest;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}
