<h2 class="dashboard__titulo">
    <?php echo $titulo?>
</h2>

<div class="dashboard__contenedor-boton">
    <a href="/admin/eventos/crear" class="dashboard__boton">
        <i class="fa-solid fa-circle-plus"></i>
        Agregar Evento
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($eventos)) {?>

        <table class="table">
            <thead class="table__head">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Categoria</th>
                    <th scope="col" class="table__th">Hora y Fecha</th>
                    <th scope="col" class="table__th">Ponente</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__body">
                <?php foreach($eventos as $evento) {; ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $evento->nombre?>
                        </td>
                        <td class="table__td">
                            <?php echo $evento->categoria->nombre?>
                        </td>
                        <td class="table__td">
                            <?php echo $evento->dia->nombre . ' @ ' . $evento->horas->hora?>
                        </td>
                        <td class="table__td">
                            <?php echo $evento->ponente->nombre . ' ' . $evento->ponente->apellido?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__acciones table__acciones--editar" href="/admin/eventos/editar?id=<?php echo $evento->id?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form method="POST" action="/admin/eventos/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $evento->id?>">
                                <button class="table__acciones table__acciones--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php }; ?>
            </tbody>
        </table>

    <?php }else {?>
        <p class="text-center">No hay eventos aún</p>
    <?php }?>
</div>

<?php echo $paginacion; ?>
