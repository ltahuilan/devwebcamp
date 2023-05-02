<?php 

namespace Controllers;

use MVC\Router;
use Model\Dia;
use Model\Hora;
use Model\Categoria;
use Model\Evento;

class EventosController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        
        $router->render('admin/eventos/index', [
            'titulo'=>'Conferencias y Workshops'
        ]);
    }
    
    
    public static function crear(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $categorias = Categoria::all();
        $dias = Dia::all();
        $horas = Hora::all();

        $evento = new Evento;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }

            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if(empty($alertas)) {
                $resultado = $evento->guardar();

                if($resultado) {
                    header('Location: /admin/eventos');
                }
            }
        }

        $router->render('admin/eventos/crear', [
            'titulo' => 'Registrar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

}
