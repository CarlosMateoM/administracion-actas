<?php

namespace aplicacion;

require_once 'Jwt.php';
require_once './excepciones/InvalidSignatureException.php';

use excepciones\InvalidSignatureException;
use Exception;

class AuthMiddleware
{

    public function __construct(
        private Jwt $JwtCtrl
    )
    {
        
    }

    public function handle(): bool
    {

        if (!preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authorization header"]);
            return false;
        }

        try {

            $this->JwtCtrl->decode($matches[1]);

        } catch (InvalidSignatureException) {

            http_response_code(401);
            echo json_encode(["message" => "invalid signature"]);
            return false;

        } catch (Exception $e) {

            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return false;
        }



        return true;
    }
}