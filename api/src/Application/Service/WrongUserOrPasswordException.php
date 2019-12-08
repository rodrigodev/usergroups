<?php


namespace App\Application\Service;


class WrongUserOrPasswordException extends \Exception
{

    /**
     * WRONG_USER_OR_PASSWORD_EXCEPTION constructor.
     */
    public function __construct()
    {
        parent::__construct("Wrong user or password", 100, null);
    }
}