<?php 

namespace excepciones;

class TokenExpiredException extends \Exception
{
    public function __construct($message = 'Token expired', $code = 401, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}