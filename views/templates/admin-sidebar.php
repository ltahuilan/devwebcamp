<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/admin/dashboard" class="dashboard__enlace <?php echo enlace_actual('/dashboard') ? 'dashboard__enlace--activo' : ''; ?>">
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu-texto">Inicio</span>
        </a>
        <a href="/admin/ponentes?page=1" class="dashboard__enlace <?php echo enlace_actual('/ponentes') ? 'dashboard__enlace--activo' : ''; ?>">
            <i class="fa-solid fa-microphone dashboard__icono"></i>
            <span class="dashboard__menu-texto">Ponentes</span>
        </a>
        <a href="/admin/eventos?page=1" class="dashboard__enlace <?php echo enlace_actual('/eventos') ? 'dashboard__enlace--activo' : ''; ?>">
            <i class="fa-solid fa-calendar dashboard__icono"></i>
            <span class="dashboard__menu-texto">Eventos</span>
        </a>
        <a href="/admin/registrados" class="dashboard__enlace <?php echo enlace_actual('/registrados') ? 'dashboard__enlace--activo' : ''; ?>">
            <i class="fa-solid fa-users dashboard__icono"></i>
            <span class="dashboard__menu-texto">Registrados</span>
        </a>
        <a href="/admin/regalos" class="dashboard__enlace <?php echo enlace_actual('/regalos') ? 'dashboard__enlace--activo' : ''; ?>">
            <i class="fa-solid fa-gift dashboard__icono"></i>
            <span class="dashboard__menu-texto">Regalos</span>
        </a>
    </nav>
</aside>