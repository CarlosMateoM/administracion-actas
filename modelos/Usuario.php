<?php

namespace modelos;

require_once './aplicacion/Modelo.php'; 

use aplicacion\Modelo;

class Usuario extends Modelo
{
    protected string $tabla = 'usuarios';
    
    protected array $attributes = [
        'nombre' => null,
        'apellidos' => null,
        'correo' => null,
        'contrasenha' => null
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
