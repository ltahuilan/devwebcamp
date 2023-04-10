<?php 

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {

    public static function index(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }
        
        //leer pagina actual del query string y garantizar se muestre numero entero
        $pagina_actual = filter_var($_GET['page'], FILTER_VALIDATE_INT);

        //Esta condicion garantiza que siempre se muestre al menos la pagina 1 en el query string
        if(!$pagina_actual || $pagina_actual < 0) {
            header('Location: /admin/ponentes?page=1');
        }

        $regisros_por_pagina = 5;
        $total_registros = Ponente::total_registros();      
        $paginacion = new Paginacion($pagina_actual, $regisros_por_pagina, $total_registros);

        //evitar se consulte una página mayor al total de paginas
        if($pagina_actual > $paginacion->total_paginas()) {
            header('Location: /admin/ponentes?page=1');
        }

        $ponentes = Ponente::paginar($regisros_por_pagina, $paginacion->offset());

        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
        
    }

    public static function crear(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $ponente = new Ponente();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            //leer las imagenes
            if(!empty($_FILES['imagen']['tmp_name'])) {
                
                //validar si existe directorio de imagenes
                $carpeta_imagenes = '../public/img/uploads';
                
                if(!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0777, true);
                }
                
                //generar las versiones de las imagenes
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 90);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 90);
                
                //generar nombre imagen
                $nombre_imagen = md5( uniqid( rand(), true));
                
                $_POST['imagen'] = $nombre_imagen;
            }
            
            //convertir el array de redes en una cadena de texto y reescribir $_POST['redes]
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            
            //sincronizar con lo que hay en $_POST
            $ponente->sincronizar($_POST);
            // debuguear($ponente);

            //validar los campos del formulario
            $alertas = $ponente->validar();
            
            if( empty($alertas) ) {

                //guardar las imagenes en disco
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');

                //guardar en la base de datos
                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }                
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Crear Nuevo Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)//llena el campo value en el formulario si hay alertas
        ]);

    }

    public static function editar(Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        //obtener y sanitizar el id
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        //si no existe un id redireccionar
        if(!$id) {
            header('Location: /admin/ponentes');
        }

        //encontrar el registro en la base de datos
        $ponente = Ponente::find($id);

        //redireccionar si el ponente no se encontró
        if(!$ponente){
            header('Location: /admin/ponentes');
        }
        
        //variable temporal o auxiliar $imagen_actual
        $ponente->imagen_actual = $ponente->imagen;

        //convertir redes sociales en array para llenar los inputs
        $redes = json_decode($ponente->redes);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            //detectar si se actualizó la imagen
            if(!empty($_FILES['imagen']['tmp_name'])){

                //generar versiones de imagenes
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 90);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 90);

                //generar el nombre de la imagen
                $nombre_imagen = md5(uniqid(rand()));

                //asignar el nombre al campo de la imagen
                $_POST['imagen'] = $nombre_imagen;

            }else {
                //si no se ha seleccionada una nueva imagen asignar el nombre de la imagen existente
                $_POST['imagen'] = $ponente->imagen;
            }

            //convertir el array de redes en una cadena de texto y reescribir $_POST['redes]
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            
            //sincronizar con lo que hay en $_POST
            $ponente->sincronizar($_POST);

            //validar los campos del formulario
            $alertas = $ponente->validar();
             
            if( empty($alertas) ) {
                $carpeta_imagenes = '../public/img/uploads';

                //si existe la variable $nombre_imagen entoces la imagen se actualizó
                if( isset($nombre_imagen) ){
                    //guardar las imagenes en disco
                    $imagen_png->save($carpeta_imagenes . '/' . $_POST['imagen'] . '.png');
                    $imagen_webp->save($carpeta_imagenes . '/' . $_POST['imagen'] . '.webp');

                    //borrar las imagenes anteriores
                    unlink($carpeta_imagenes . '/' . $ponente->imagen_actual . '.png');
                    unlink($carpeta_imagenes . '/' . $ponente->imagen_actual . '.webp');
                }

                //guardar en la base de datos
                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }                
            }

        }

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Editar Ponente',
            'ponente' => $ponente,
            'redes' => $redes
        ]);
    }

    public static function eliminar() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            //obtner y sanitizar el id
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            
            $ponente = Ponente::find($id);

            //si no existe el registro
            if(!isset($ponente)){
                header('Location: /admin/ponentes');
                return;
            }
            
            $resultado = $ponente->eliminar();

            if($resultado) {
                //eliminar imagenes
                unlink('../public/img/uploads' . '/' . $ponente->imagen . '.png');
                unlink('../public/img/uploads' . '/' . $ponente->imagen . '.webp');

                header('Location: /admin/ponentes');
            }
        }
    }
}


?>