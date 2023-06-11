<div class="evento swiper-slide">
    <p class="evento__hora"><?php echo $evento->horas->hora; ?></p>

    <div class="evento__informacion">
        <h4 class="evento__nombre"><?php echo $evento->nombre ?></h4>
        <p class="evento__introduccion"><?php echo $evento->descripcion ?></p>

        <div class="evento__autor-info">
            <picture>
                <source srcset="img/uploads/<?php echo $evento->ponente->imagen ?>.webp" type="image/webp">
                <source srcset="img/uploads/<?php echo $evento->ponente->imagen ?>.png" type="image/png">
                <img loading="lazy" width="200" height="300" src="img/uploads/<?php echo $evento->ponente->imagen ?>.jpg" alt="<?php echo 'imagen ' . $ponente->nombre . ' ' . $ponente->apellido ?>" class="evento__autor-imagen">
            </picture>
            <h4 class="evento__autor-nombre"><?php echo $evento->ponente->nombre . ' ' . $evento->ponente->apellido ?></h4>
        </div>
    </div>
</div> <!-- swiper-slide -->