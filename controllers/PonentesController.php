<?php 

namespace Controllers;

use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {

    public static function index(Router $router) {

        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes'
        ]);
        
    }

    public static function crear(Router $router) {

        $ponente = new Ponente();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            debuguear($ponente);
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Crear Nuevo Ponente'
        ]);

    }
}


?>