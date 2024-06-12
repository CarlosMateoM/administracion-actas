<?php

namespace vista;

class Respuesta
{
    public static function json($data, $code = 200)
    {
        http_response_code($code);
        echo json_encode($data);
    }
}