<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?></h2>
    <p class="auth__text">Recupera tu password de tu cuenta DevWebcamp</p>

    <?php include_once __DIR__ . '/../templates/alertas.php';?>

    <?php if($token_valido) {; ?>
        <form method="POST" class="formulario">

            <div class="formulario__bloque">
                <label for="password" class="formulario__label">Nuevo Password:</label>
                <input
                    type="password"
                    class="formulario__input"
                    placeholder="Tu Nuevo Password"
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

            <input type="submit" class="formulario__submit" value="Guardar Password">

        </form>

    <?php }; ?>
    
    <?php if(!$token_valido) {;?>
        <div class="acciones--centrar">
            <a href="/registro" class="acciones__enlace">¿Aún no tienes una? Crear cuenta</a>
            <!-- <a href="/recuperar" class="acciones__enlace">¿Olvidaste tu password?</a> -->
        </div>
    <?php }?>

</main>