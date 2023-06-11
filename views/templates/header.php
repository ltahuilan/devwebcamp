<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if (!is_auth()) { ?>
                <a href="/registro#registro" class="header__enlace">Registro</a>
                <a href="/login#login" class="header__enlace">Iniciar sesión</a>

            <?php } else { ?>
                <a href="<?php echo !is_admin() ? '/finalizar-registro' : '/admin/dashboard'?>" class="header__enlace">Administrar</a>
                <form method="POST" action="/logout" class="dashboard__form">
                    <input type="submit" value="Cerrar Sesión" class="dashboard__form--logout">
                </form>
            <?php } ?>
        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">
                    &#60;DevWebCamp/>
                </h1>
            </a>

            <p class="header__texto">Octubre 5-6 2023</p>
            <p class="header__texto header__texto--modalidad">En linea - Presencial</p>
            <a href="/registro" class="header__boton">Comprar Pase</a>
        </div>
    </div>
</header>
<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">
                &#60;DevWebCamp/>
            </h2>
        </a>
        <nav class="navegacion">
            <a href="/devwebcamp#devwebcamp" class="navegacion__enlace <?php echo enlace_actual('/devwebcamp') ? 'navegacion__enlace--actual' : '' ?>">
                Evento
            </a>
            <a href="/paquetes#paquetes" class="navegacion__enlace <?php echo enlace_actual('/paquetes') ? 'navegacion__enlace--actual' : '' ?>">
                Paquetes
            </a>
            <a href="/workshop-conferencias#eventos" class="navegacion__enlace <?php echo enlace_actual('/workshop-conferencias') ? 'navegacion__enlace--actual' : '' ?>">
                Workshop / Conferencias
            </a>
            <a href="/registro#registro" class="navegacion__enlace <?php echo enlace_actual('/registro') ? 'navegacion__enlace--actual' : '' ?>">
                Comprar pase
            </a>
        </nav>
    </div>
</div>