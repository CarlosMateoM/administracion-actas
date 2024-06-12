<?php

namespace aplicacion;

require_once './vista/Respuesta.php';

use vista\Respuesta;

class BaseController
{
    public function getIdParam(): ?int
    {
        $id = $_GET['id'];

        if(!$id) {
            Respuesta::json([
                'message' => 'ID de reunión no proporcionado'
            ], 400);
        }

        return $id;
    }
}   