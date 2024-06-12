<?php

namespace controladores;

require_once './modelos/Usuario.php';
require_once './vista/Respuesta.php';
require_once './aplicacion/Jwt.php';
require_once './modelos/JwtToken.php';

use aplicacion\Jwt;
use modelos\JwtToken;
use modelos\Usuario;
use vista\Respuesta;

class AuthControlador
{

    public function register(array $request)
    {
        $usuario = new Usuario();

        $usuario->nombre = $request['nombre'];
        $usuario->apellidos = $request['apellidos'];
        $usuario->correo = $request['correo'];
        $usuario->contrasenha = password_hash($request['contrasenha'], PASSWORD_DEFAULT);

        $usuario->create();

        Respuesta::json([
            'message' => 'Usuario creado correctamente'
        ]);
    }


    public function login(array $request): void
    {
        $correo = $request['correo'];
        $contrasenha = $request['contrasenha'];

        $usuario = new Usuario();
        $usuario = $usuario->where('correo', $correo)[0];

        if (!$usuario) {
            Respuesta::json([
                'message' => 'Usuario no encontrado'
            ], 404);
            return;
        }

        if (!password_verify($contrasenha, $usuario->contrasenha)) {
            Respuesta::json([
                'message' => 'Contraseña incorrecta'
            ], 401);
            return;
        }

        $jwt = new Jwt($_ENV['SECRET_KEY']);

        $access_token = $jwt->encode([
            'sub' => $usuario->id,
            'name' => $usuario->nombre,
            'exp' => time() + (60 * 120)
        ]);


        Respuesta::json([
            'access_token' => $access_token,
        ]);
    }
}


 /*
        $refresh_token_expiry = time() + 432000;

        $refresh_token = $jwt->encode([
            'sub' => $usuario->id,
            'name' => $usuario->nombre,
            'exp' => $refresh_token_expiry  
        ]);

        $jwtToken = new JwtToken();

        $jwtToken->refresh_token = hash_hmac("sha256", $refresh_token, $_ENV['SECRET_KEY']);
        $jwtToken->expires_at = date('Y-m-d H:i:s', $refresh_token_expiry);

        $jwtToken->create();

        'refresh_token' => $refresh_token
        */