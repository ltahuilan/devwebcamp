<h2 class="dashboard__titulo">
    <?php echo $titulo;?>
</h2>   

<div class="dashboard__contenedor-boton">
    <a href="/admin/ponentes" class="dashboard__boton">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Regresar
    </a>
</div>

<div class="dashboard__formulario">
    
    <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

    <form method="POST" action="/admin/ponentes/crear" enctype="multipart/form-data" class="formulario">

        <?php include_once __DIR__ . '/formulario.php';?>

        <input type="submit" value="Registrar Ponente" class="formulario__submit formulario__submit--registrar">
    </form>
</div>