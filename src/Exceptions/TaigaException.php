<?php

namespace TZK\Taiga\Exceptions;

use Exception;

class TaigaException extends Exception
{
    /**
     * TaigaException constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
