<?php

namespace modelos;

require_once './aplicacion/Modelo.php';

use aplicacion\Modelo;

class Asistente extends Modelo
{
    protected string $tabla = 'asistentes';

    protected array $attributes = [
        'usuario_id' => null,
        'reunion_id' => null
    ];

    public function __construct()
    {
        parent::__construct();
    }
}

