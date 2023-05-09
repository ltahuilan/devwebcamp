<?php 

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Dia;
use Model\Hora;
use Model\Categoria;
use Model\Evento;
use Model\Ponente;

class EventosController {

    /**
     * Muestra todos los eventos
     */
    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/eventos?page=1');
        }

        $registros_por_pagina = 6;
        $total_registros = Evento::total_registros();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        
        //evitar consultar pagina mayor al total de páginas
        if($pagina_actual > $paginacion->total_paginas()) {
            header('Location: /admin/eventos?page=1');
        }
        
        $eventos = Evento::paginar($registros_por_pagina, $paginacion->offset());
        // debuguear($eventos);

        //cruzar las tablas para obtener categoria, dia, hora y ponente
        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->horas = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }
        
        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
            'paginacion' => $paginacion->paginacion(),
            'eventos' => $eventos
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


    public static function editar(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        //consultar la BD y obtener el evento
        $evento = Evento::find($id);

        $alertas = [];
        $categorias = Categoria::all();
        $dias = Dia::all();
        $horas = Hora::all();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
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

        $router->render('admin/eventos/editar', [
            'titulo' => 'Editar Evento',
            'alertas' => $alertas,
            'evento' => $evento,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas
        ]);
    }

    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            $evento = Evento::find($id);

            if($evento) {
                $resultado = $evento->eliminar();

                if($resultado) {
                    header('Location: /admin/eventos');
                }
            }
        }
    }
}
