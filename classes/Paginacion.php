<?php 

namespace Classes;

use Model\ActiveRecord;

class Paginacion extends ActiveRecord {

    protected $pagina_actual;
    protected $registros_por_pagina;
    protected $total_paginas;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 6, $total_paginas) {
        
        $this->pagina_actual = (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_paginas = (int) $total_paginas;
    }
} 
?>