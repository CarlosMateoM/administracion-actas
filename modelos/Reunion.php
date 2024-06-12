<?php

namespace modelos;

require_once './aplicacion/Modelo.php';

use aplicacion\Modelo;

class Reunion extends Modelo
{

    protected string $tabla = 'reuniones';

    protected array $attributes = [
        'asunto' => null,
        'descripcion' => null,
        'fecha' => null,
        'lugar' => null
    ];

    public function __construct()
    {
        parent::__construct();
    }

}