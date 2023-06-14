<?php 

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {        
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    //verifica que la url actual exista
    public function comprobarRutas() {

        session_start();

        $auth = $_SESSION['login'] ?? false;

        $rutasProtegidas = [
            
        ];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';

        //$_SERVER['PATH_INFO'] no existe en apache, se implementa $_SERVER['REQUEST_URI']
        // $urlActual = $_SERVER['REQUEST_URI'] ?? '/';

        //explode() separa un string a partir del caracter indicado, retorna un array de strings
        $urlActual = explode('?', $urlActual);
        //extraer el primer elemento de un array, se almacena en una variable como string
        $urlActual = array_shift($urlActual);

        // debuguear($urlActual);

        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? NULL;
        }else {
            $fn = $this->rutasPOST[$urlActual] ?? NULL;
        }

        //si es una ruta protegida y no esta autenticado enviar a la página principal
        if( in_array($urlActual, $rutasProtegidas) && !$auth) {            
            header('Location: /');
        }

        //la url existe y tiene una funcion asociada
        if($fn) {
            //requiere la funcion y el (los) arreglo de rutas
            call_user_func($fn, $this);
        }else {
            // echo 'ERROR 404: Página No Encontrada o Ruta no válida...';
            header('Location: /pagina_404');
        }
    }

    public function render($view, $datos = []) {

        //iterar el arreglo de datos para utilizarlos en la vista
        foreach($datos as $key => $value) {
            /**doble $$ es una variable variable, crea el nombre de la variable
             * basado en la llave del arreglo asociativo y matiene la referencia */
            $$key = $value;
        }

        ob_start(); //crea un bufer
        include_once __DIR__."/views/$view.php";
        $contenido = ob_get_clean(); //asigna el buffer a la variable y después lo limpia


        //mostrar la vista de acuerdo al rol de usuario
        $current_url = $_SERVER['PATH_INFO'] ?? '/';

        // debuguear($current_url);

        if( str_contains($current_url, '/admin') ) {
            include_once __DIR__.'/views/admin-layout.php';
        }else {
            include_once __DIR__.'/views/layout.php';
        }

        /**El contenido de la vista se almacena en la variable $contenido
         * se renderiza el layout.php y, en éste, se puede llamar la variable $contenido
         * para mostrar dinamicamente distintas vistas
         */
    }
}

?>