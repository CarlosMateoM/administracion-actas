<?php

namespace excepciones;

class InvalidSignatureException extends \Exception
{
    public function __construct($message = 'Invalid signature', $code = 401, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
