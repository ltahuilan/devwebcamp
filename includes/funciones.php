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

function esUltimo($id_actual, $id_siguiente) {

    if ($id_actual === $id_siguiente) {
        return false;
    }
    return true;
};

//Verifica se se ha iniciado sesión
function is_auth() : bool {
    if (!$_SESSION) {
        session_start();
    }

    return isset($_SESSION['nombre']) && !empty($_SESSION);
};

function is_admin() : bool {
    if (!$_SESSION) {
        session_start();
    }
    
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
};


/**
 * Verifica si la url contiene una cadena de texto
 * Se utilizará para agregar una clase al enlace seleccionado
 */
function enlace_actual($str_href) {   
    $url_actual = $_SERVER["PATH_INFO"];
    return str_contains($url_actual, $str_href ?? '/') ? true : false;
}
