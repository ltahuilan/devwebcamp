<?php 

namespace Model;

class Ponente extends ActiveRecord {

    protected static $tabla = 'ponentes';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'ciudad', 'pais', 'imagen', 'tags',  'redes'];

    public $id;
    public $nombre;
    public $apellido;
    public $ciudad;
    public $pais;
    public $imagen;
    public $tags;
    public $redes;

    public function __construct($args=[]) {

        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->ciudad = $args['ciudad'] ?? '';
        $this->pais = $args['pais'] ?? '';
        $this->imagen = $args['imagen'] ?? ''; 
        $this->tags = $args['tags'] ?? '';
        $this->redes = $args['redes'] ?? '';
    }

    public function validar() {

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El campo nombre es requerido';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El campo apellido es requerido';
        }
        if(!$this->ciudad) {
            self::$alertas['error'][] = 'El campo ciudad es requerido';
        }
        if(!$this->pais) {
            self::$alertas['error'][] = 'El campo pais es requerido';
        }
        if(!$this->imagen) {
            self::$alertas['error'][] = 'El campo imagen es requerido';
        }
        if(!$this->tags) {
            self::$alertas['error'][] = 'El campo tags es requerido';
        }

        return self::$alertas;
    }

}



?>