<?php

namespace App\Controller;

use App\Core\View;
use App\Dominio\Auto;
use Exception;

class AutosController
{
    // $id recibirá "15", $color recibirá "azul"
    public function listar()
    {
        // View::render('autos/listar', ['nombre' => $nombre]);

        $autos = [];
        try {
            $autos = Auto::listar();
            View::render('autos/listar', ['autos' => $autos]);
        } catch (Exception $e) {
            View::render('mensaje/comun.php', [
                'titulo' => 'Error al obtener los autos',
                'mensaje' => $e->getMessage(),
            ]);
        }
    }
}
