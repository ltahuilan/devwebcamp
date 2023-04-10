<?php 

namespace Classes;

use Model\ActiveRecord;

class Paginacion extends ActiveRecord {

    protected $pagina_actual;
    protected $registros_por_pagina;
    protected $total_registros;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 6, $total_registros) {

        $this->pagina_actual = (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
    }

    //calcular el offset
    public function offset() {
        return $this->registros_por_pagina * ($this->pagina_actual - 1 );
    }

    //calcular el total de paginas
    public function total_paginas() {
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    //metodo que detecta la pagina siguiente
    public function pagina_siguiente() {
        $siguiente = $this->pagina_actual + 1;
        return ($this->pagina_actual < $this->total_paginas()) ? $siguiente : false;

    }

    //metodo que detecta la pagina anterior
    public function pagina_anterior() {
        $anterior = $this->pagina_actual - 1;
        return ($this->pagina_actual > 1) ? $anterior : false;
    }

    //metodo que muestra enlace hacia la pagina siguiente
    public function enlace_pagina_siguiente() {
        $html = "";
        if($this->pagina_siguiente()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }

    //metodo que muestra enlace hacia la pagina anterior
    public function enlace_pagina_anterior() {
        $html = "";
        if($this->pagina_anterior()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}\">&laquo; Anterior</a>";
        }
        return $html;
    }

    public function enlace_numeros() {
        $html = "";
        for($i = 1; $i <= $this->total_paginas(); $i++) {
            if($i === $this->pagina_actual){
                $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\" href=\"?page={$i}\">{$i}</span>";
            }else{
                $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i}\">{$i}</a>";
            }
        }
        return $html;
    }

    //metodo que ejecuta la paginacion
    public function paginacion() {
        $html = '';
        if($this->total_paginas() > 0 ) {
            $html .= '<div class="paginacion">';
            $html .= $this->enlace_pagina_anterior();
            $html.= $this->enlace_numeros();
            $html .= $this->enlace_pagina_siguiente();
            $html .= '</div>';
        }
        return $html;
    }
} 
?>