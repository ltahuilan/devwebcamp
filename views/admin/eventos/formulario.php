<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del evento</legend>

    <div class="formulario__bloque">
        <label for="nombre" class="formulario__label">Nombre del evento</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre del evento"
            value="<?php echo $evento->nombre?>"
        >
    </div>

    <div class="formulario__bloque">
        <label for="descripcion" class="formulario__label">Descripcion del evento</label>
        <textarea
            type="text"
            class="formulario__input"
            id="descripcion"
            name="descripcion"
            placeholder="Descripcion del evento"
            rows="6"
        ><?php echo $evento->descripcion?></textarea>
    </div>

    <div class="formulario__bloque">
        <label for="categoria" class="formulario__label">Categoria o tipo de evento</label>
        <select id="categoria" name="categoria_id" class="formulario__select">
            <option value="">-Seleccionar-</option>
            <?php forEach($categorias as $categoria) {?>
                <option 
                    <?php echo ($evento->categoria_id === $categoria->id) ? 'selected' : ''?>
                    value="<?php echo $categoria->id?>"><?php echo $categoria->nombre?>
                </option>
            <?php }?>
        </select>
    </div>

    <div class="formulario__bloque">
        <label for="dia" class="formulario__label">Selecciona el día</label>

        <div class="formulario__radio">
            <?php forEach($dias as $dia) { ?>
                <div>
                    <label for="<?php echo strtolower($dia->nombre)?>">
                        <?php echo $dia->nombre?>
                    </label>
                    <input
                        type="radio"
                        name="dia"
                        id="<?php echo strtolower($dia->nombre)?>"
                        value="<?php echo $dia->id?>"
                    >
                </div>
            <?php }?>
        </div>
        <input type="hidden" name="dia_id" value="">
    </div>

    <div class="formulario__bloque">
        <label for="dia" class="formulario__label">Selecciona la hora</label>
        <ul id="horas" class="horas">
            <?php forEach($horas as $hora) {?>
                <li data-hora-id="<?php echo $hora->id?>" class="horas__hora horas__hora--desactivada"><?php echo $hora->hora?></li>
            <?php }?>
        </ul>

        <input type="hidden" name="hora_id" value="">

    </div>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Adicional</legend>
    <div class="formulario__bloque">
        <label for="ponentes" class="formulario__label">Buscar Ponente</label>
        <input
            type="text"
            class="formulario__input"
            id="ponentes"
            placeholder="Buscar ponente"
            value=""
        >
        <input
            type="hidden"
            id="ponente_id"
            name="ponente_id"
            value=""
        >
    </div>

    <ul id="lista-ponentes" class="lista-ponentes"></ul>

    <div class="formulario__bloque">
        <label for="disponibles" class="formulario__label">Lugares disponibles</label>
        <input
            type="number"
            class="formulario__input"
            id="disponibles"
            min="1"
            name="disponibles"
            placeholder="Ej. 20"
            value="<?php echo $evento->disponibles?>"
        >
    </div>
</fieldset>
