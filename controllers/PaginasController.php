<?php 

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Ponente;
use Model\Categoria;

class PaginasController {

    public static function index(Router $router) {
        $eventos_formateados = [];
        $eventos = Evento::ordenar('hora_id', 'ASC');

        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->horas = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            
            if($evento->categoria_id == 1 && $evento->dia_id == 1) {
                $eventos_formateados['conferencias_viernes'][] = $evento;
            }
            if($evento->categoria_id == 1 && $evento->dia_id == 2) {
                $eventos_formateados['conferencias_sabado'][] = $evento;
            }
            if($evento->categoria_id == 2 && $evento->dia_id == 1) {
                $eventos_formateados['workshops_viernes'][] = $evento;
            }
            if($evento->categoria_id == 2 && $evento->dia_id == 2) {
                $eventos_formateados['workshops_sabado'][] = $evento;
            }
            // debuguear($eventos_formateados);
        };

        $total_ponentes = Ponente::total_registros();
        $total_conferencias = Evento::total_registros('categoria_id', 1);
        $total_workshops = Evento::total_registros('categoria_id', 2);
        $ponentes = Ponente::all();
        // debuguear($total_conferencias);

        $router->render('/paginas/index', [
            'titulo' => 'DevWebCamp',
            'eventos' => $eventos_formateados,
            'total_ponentes' => $total_ponentes,
            'total_conferencias' => $total_conferencias,
            'total_workshops' => $total_workshops,
            'ponentes' => $ponentes
        ]);
    }

    public static function evento(Router $router) {

        $router->render('/paginas/devwebcamp', [
            'titulo' => 'Sobre DevWebCamp'
        ]);
    }

    public static function paquetes(Router $router) {

        $router->render('/paginas/paquetes', [
            'titulo' => 'Paquetes DevWebCamp'
        ]);
    }

    public static function conferencias(Router $router) {
        $eventos_formateados = [];
        $eventos = Evento::ordenar('hora_id', 'ASC');

        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->horas = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            
            if($evento->categoria_id == 1 && $evento->dia_id == 1) {
                $eventos_formateados['conferencias_viernes'][] = $evento;
            }
            if($evento->categoria_id == 1 && $evento->dia_id == 2) {
                $eventos_formateados['conferencias_sabado'][] = $evento;
            }
            if($evento->categoria_id == 2 && $evento->dia_id == 1) {
                $eventos_formateados['workshops_viernes'][] = $evento;
            }
            if($evento->categoria_id == 2 && $evento->dia_id == 2) {
                $eventos_formateados['workshops_sabado'][] = $evento;
            }
            // debuguear($eventos_formateados);
        };

        $router->render('/paginas/conferencias', [
            'titulo' => 'Workshops y Conferencias',
            'eventos' => $eventos_formateados
        ]);
    }


    public static function error(Router $router) {

        $router->render('/paginas/pagina_404', [
            'titulo' => 'Error 404'
        ]);
    }
}
