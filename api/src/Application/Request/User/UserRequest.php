<?php

namespace App\Application\Request\User;

use Symfony\Component\HttpFoundation\Request;
use App\Application\Exceptions\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRequest
 * @package App\Application\Request\User
 */
class UserRequest
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $username;

    /**
     * UserRequest constructor.
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
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return UserRequest
     * @throws ValidationException
     */
    public static function createFromRequest(Request $request, ValidatorInterface $validator): UserRequest
    {
        $userRequest = new self(
            $request->request->get('name'),
            $request->request->get('username'),
            $request->request->get('password')
        );

        $errors = $validator->validate($userRequest);

        if (count($errors) > 0) {
            throw new ValidationException((string) $errors);
        }

        return $userRequest;
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
