<?php

namespace controladores;

require_once './aplicacion/BaseController.php';
require_once './modelos/Acta.php';
require_once './vista/Respuesta.php';

use aplicacion\BaseController;
use modelos\Acta;
use vista\Respuesta;

class ActasControlador extends BaseController
{
    public function index(): void
    {
        $actas = new Acta();

        $actas = $actas->all();

        Respuesta::json($actas);
    }

    public function show(): void
    {
        $id = $this->getIdParam();

        $actas = new Acta();

        $actas = $actas->find($id);

        Respuesta::json($actas);
    }

    public function store(array $request): void
    {
        $actas = new Acta();

        $actas->usuario_id = $request['usuario_id'];
        $actas->reunion_id = $request['reunion_id'];
        $actas->titulo = $request['titulo'];
        $actas->fecha = $request['fecha'];

        $actas->create();

        Respuesta::json([
            'message' => 'Acta creada correctamente'
        ]);
    }

    public function delete(): void
    {
        $id = $this->getIdParam();

        $actas = new Acta();

        $actas = $actas->delete($id);

        Respuesta::json([
            'message' => 'Acta eliminada correctamente'
        ]);
    }
}
