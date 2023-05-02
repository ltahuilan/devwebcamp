<main class="auth">
    <h2 class="auth__heading" id="auth-heading"><?php echo $titulo ?></h2>
    <p class="auth__text">Inicia sesión en DevWebcamp</p>

    <?php include_once __DIR__ . '/../templates/alertas.php'?>

    <form method="POST" action="" id="login" class="formulario">
        <div class="formulario__bloque">
            <label for="email" class="formulario__label">Email:</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Tu Email"
                id="email"
                name="email"
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

        <input type="submit" class="formulario__submit" value="Iniciar Sesión">

    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes una? Crear cuenta</a>
        <a href="/recuperar" class="acciones__enlace">¿Olvidaste tu password?</a>
    </div>

</main>