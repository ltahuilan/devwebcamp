<main class="auth">
    <h2 class="auth__heading" id="#auth-heading"><?php echo $titulo ?></h2>
    <p class="auth__text">Registrate en DevWebcamp</p>

    <?php 
        include_once __DIR__ . '/../templates/alertas.php';
    ?>

    <form id="registro" method="POST" action="/registro" class="formulario">
        <div class="formulario__bloque">
            <label for="nombre" class="formulario__label">Nombre:</label>
            <input
                type="text"
                class="formulario__input"
                placeholder="Tu Nombre"
                id="nombre"
                name="nombre"
                value="<?php echo $usuario->nombre?>"
            >
        </div>

        <div class="formulario__bloque">
            <label for="apellido" class="formulario__label">Apellido:</label>
            <input
                type="text"
                class="formulario__input"
                placeholder="Tu Apellido"
                id="apellido"
                name="apellido"
                value="<?php echo $usuario->apellido?>"
            >
        </div>

        <div class="formulario__bloque">
            <label for="email" class="formulario__label">Email:</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Tu Email"
                id="email"
                name="email"
                value="<?php echo $usuario->email?>"
            >
        </div>

        <div class="formulario__bloque">
            <label for="password" class="formulario__label">Password:</label>
            <input
                type="password"
                class="formulario__input"
                placeholder="Tu Password"
                id="password"
                name="password"
            >
        </div>

        <div class="formulario__bloque">
            <label for="password2" class="formulario__label">Repite tu Password:</label>
            <input
                type="password"
                class="formulario__input"
                placeholder="Repite tu Password"
                id="password2"
                name="password2"
            >
        </div>

        <input type="submit" class="formulario__submit" value="Crear Cuenta">

    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Inicia Sesión</a>
        <a href="/recuperar" class="acciones__enlace">¿Olvidaste tu password?</a>
    </div>

</main>