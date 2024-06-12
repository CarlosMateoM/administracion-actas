<?php

namespace modelos;

require_once './aplicacion/Modelo.php';

use aplicacion\Modelo;

class Acta extends Modelo
{
    protected string $tabla = 'actas';

    protected array $attributes = [
        'usuario_id' => null,
        'reunion_id' => null,
        'titulo' => null,
        'fecha' => null
    ];

    protected array $relations = [
        'usuarios' => [
            'table' => 'usuarios',
            'foreign_key' => 'usuario_id',
        ],
        'reuniones' => [
            'table' => 'reuniones',
            'foreign_key' => 'reunion_id'
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }
}