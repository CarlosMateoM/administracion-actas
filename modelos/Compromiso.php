<?php
require_once './aplicacion/Modelo.php';

use aplicacion\Modelo;

class Compromiso extends Modelo
{
    protected string $tabla = 'compromisos';

    protected array $attributes = [
        'acta_id' => null,
        'usuario_id' => null,
        'compromiso' => null
    ];

    public function __construct()
    {
        parent::__construct();
    }
    
}