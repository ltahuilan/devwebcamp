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
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();
            debuguear($ponente);

            if( empty($alertas) ) {

                //convertir array de redes sociales en string

                //guardar en la base de datos
                
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Crear Nuevo Ponente',
            'alertas' => $alertas
        ]);

    }
}


?>