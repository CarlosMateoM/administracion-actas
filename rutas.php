<?php

require_once 'aplicacion/AuthMiddleware.php'; 
require_once 'aplicacion/Enrutador.php';

use aplicacion\AuthMiddleware;
use aplicacion\Enrutador;

Enrutador::post('/register', 'AuthControlador', 'register');
Enrutador::post('/login', 'AuthControlador', 'login');

Enrutador::group([AuthMiddleware::class], function() {

    Enrutador::get('/usuarios/index', 'UsuarioControlador', 'index');

    Enrutador::get('/actas/index', 'ActasControlador', 'index');
    Enrutador::get('/actas/show', 'ActasControlador', 'show');
    Enrutador::post('/actas/create', 'ActasControlador', 'store');
    Enrutador::put('/actas/update', 'ActasControlador', 'update');
    Enrutador::delete('/actas/delete', 'ActasControlador', 'delete');
    
    Enrutador::get('/reuniones/index', 'ReunionesControlador', 'index');
    Enrutador::get('/reuniones/show', 'ReunionesControlador', 'show');
    Enrutador::post('/reuniones/create', 'ReunionesControlador', 'store');
    Enrutador::put('/reuniones/update', 'ReunionesControlador', 'update');
    Enrutador::delete('/reuniones/delete', 'ReunionesControlador', 'delete');

    Enrutador::get('/asistentes/index', 'AsistentesControlador', 'index');
    Enrutador::post('/asistentes/create', 'AsistentesControlador', 'store');
    Enrutador::delete('/asistentes/delete', 'AsistentesControlador', 'delete');



});
    

Enrutador::dispatch();
