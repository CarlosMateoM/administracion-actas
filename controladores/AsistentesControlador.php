<?php

namespace controladores;

require_once './aplicacion/BaseController.php';
require_once './modelos/Asistente.php';
require_once './vista/Respuesta.php';

use aplicacion\BaseController;
use modelos\Asistente;
use vista\Respuesta;

class AsistentesControlador extends BaseController
{
    public function index(): void
    {
        $asistentes = new Asistente();

        $asistentes = $asistentes->all(['usuarios', 'reuniones']);

        Respuesta::json($asistentes);
    }

    public function store(array $request): void
    {
        $asistente = new Asistente();

        $asistente->usuario_id = $request['usuario_id'];
        $asistente->reunion_id = $request['reunion_id'];
   
        $asistente->create();

        Respuesta::json([
            'message' => 'Acta creada correctamente'
        ]);
    }

    public function delete(): void
    {
        $id = $this->getIdParam();

        $asistente = new Asistente();

        $asistente = $asistente->delete($id);

        Respuesta::json([
            'message' => 'Acta eliminada correctamente'
        ]);
    }
}