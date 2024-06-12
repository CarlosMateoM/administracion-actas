<?php

namespace controladores;

require_once './aplicacion/BaseController.php';
require_once './modelos/Reunion.php';
require_once './vista/Respuesta.php';

use aplicacion\BaseController;
use modelos\Reunion;
use vista\Respuesta;

class ReunionesControlador extends BaseController
{
    public function index(): void
    {
        $reuniones = new Reunion();
        $reuniones = $reuniones->all();

        Respuesta::json($reuniones);
    }

    public function show(): void
    {
        $id = $this->getIdParam();

        $reunion = new Reunion();
        $reunion = $reunion->find($id);

        Respuesta::json($reunion);
    }

    public function store(array $request): void
    {
        $reunion = new Reunion();

        $reunion->asunto = $request['asunto'];
        $reunion->descripcion = $request['descripcion'];
        $reunion->fecha = $request['fecha'];
        $reunion->lugar = $request['lugar'];

        $reunion->create();

        Respuesta::json([
            'message' => 'Reunión creada correctamente'
        ]);
    }

    public function delete(): void
    {
        $id = $this->getIdParam();

        $reunion = new Reunion();

        $reunion = $reunion->delete($id);

        Respuesta::json([
            'message' => 'Reunión eliminada correctamente'
        ]);
    }

    public function update(array $request): void
    {
        $id = $this->getIdParam();

        $reunion = new Reunion();

        $reunion->asunto = $request['asunto'];
        $reunion->descripcion = $request['descripcion'];
        $reunion->fecha = $request['fecha'];
        $reunion->lugar = $request['lugar'];

        $reunion = $reunion->update($id);

        Respuesta::json([
            'message' => 'Reunión actualizada correctamente'
        ]);
    }
}
