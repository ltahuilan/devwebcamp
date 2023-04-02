<?php

/**
 * Auth: Luis Tahuilán
 * Proyecto origen: UpTask
 */

define('TEMPLATES_URL', __DIR__  .  '/templates');
define('FUNCIONES_URL', 'funciones.php');
define('DIR_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/img/speakers/');

function incluirTemplates (string $template, bool $inicio = false, bool $admin = false) {
    include TEMPLATES_URL . "/${template}.php";
};

/**
 * helper que comprueba si un usuario ha inciado sesión
 */
function autenticado() {
    session_start();    
    if ( !isset($_SESSION['login']) ) {
        header('location: /');
    }
};


function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
};

// Escapa / Sanitizar el HTML
function sanitizar($html) : string {
    $sanitizar = htmlspecialchars($html);
    return $sanitizar;
};

function esUltimo ($id_actual, $id_siguiente) {

    if ($id_actual === $id_siguiente) {
        return false;
    }
    return true;
};

//Verifica se se ha iniciado sesión
function isAuth () : void{
    if (!$_SESSION) {
        session_start();
    }

    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }

    // if (!isset($_SESSION['admin'])) {
    //     header('Location: /citas');
    // }
};

function isAdmin () {
    if (!isset($_SESSION['admin'])) {
        header('Location: /');
    }
};


/**
 * Verifica si la url contiene una cadena de texto
 * Se utilizará para agregar una clase al enlace seleccionado
 */
function enlace_actual($str_href) {
   
    $url_actual = $_SERVER["PATH_INFO"];

    return str_contains($url_actual, $str_href) ? true : false;
}
