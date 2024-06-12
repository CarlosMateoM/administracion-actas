<?php

namespace modelos;

require_once './aplicacion/Modelo.php';

use aplicacion\Modelo;

class JwtToken extends Modelo
{

    protected string $primaryKey = 'refresh_token';
    protected string $tabla = 'jwt_tokens';

    protected array $attributes = [
        'refresh_token' => null,
        'expires_at' => null,
    ];

    public function __construct()
    {
        parent::__construct();
    }

}
    