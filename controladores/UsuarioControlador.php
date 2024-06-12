<?php

namespace controladores;

require_once './aplicacion/BaseController.php';
require_once './vista/Respuesta.php';
require_once './modelos/Usuario.php';

use aplicacion\BaseController;
use modelos\Usuario;
use vista\Respuesta;

class UsuarioControlador extends BaseController
{
    public function index(): void
    {
        $usuarios = new Usuario();
        
        $usuarios = $usuarios->all();

        Respuesta::json($usuarios);
    }
}