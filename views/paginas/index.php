<?php include_once __DIR__ . '/conferencias.php' ?>

<section class="resumen">
    <div class="resumen__grid">
        <div class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $total_ponentes ?></p>
            <p class="resumen__texto">Speakers</p>
        </div>
        <div class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $total_conferencias ?></p>
            <p class="resumen__texto">Conferencias</p>
        </div>
        <div class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $total_workshops ?></p>
            <p class="resumen__texto">Workshops</p>
        </div>
        <div class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero">500</p>
            <p class="resumen__texto">Asistentes</p>
        </div>
    </div>
</section>

<section class="ponentes">
    <h3 class="ponentes__heading">Ponentes</h3>
    <p class="ponentes__descripcion">Conoce a nuestros expertos en DevWebCamp</p>

    <div class="ponentes__grid">
        <?php foreach ($ponentes as $ponente) { ?>
            <div class="ponente">
                <picture>
                    <source srcset="img/uploads/<?php echo $ponente->imagen; ?>.webp" type="image/webp">
                    <source srcset="img/uploads/<?php echo $ponente->imagen; ?>.png" type="image/png">
                    <img class="ponente__imagen" loading="lazy" width="200" height="300" src="img/upload/<?php echo $ponente->imagen; ?>.png" alt="Imagen de <?php echo $ponente->nombre . ' ' . $ponente->apellido ?>">
                </picture>

                <div class="ponente__informacion">
                    <h4 class="ponente__nombre"><?php echo $ponente->nombre . ' ' . $ponente->apellido; ?></h4>
                    <p class="ponente__ubicacion"><?php echo $ponente->ciudad . ', ' . $ponente->pais; ?></p>

                    <?php
                        $redes = json_decode($ponente->redes);
                    ?>

                    <nav class="ponente-sociales">
                        <?php if($redes->facebook) {; ?>
                            <a class="ponente-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->facebook?>">
                                <span class="ponente-sociales__ocultar">Facebook</span>
                            </a>                            
                        <?php }; ?>

                        <?php if($redes->twitter) {; ?>
                            <a class="ponente-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->twitter?>">
                                <span class="ponente-sociales__ocultar">Twitter</span>
                            </a>                            
                        <?php }; ?>

                        <?php if($redes->youtube) {; ?>
                            <a class="ponente-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->youtube?>">
                                <span class="ponente-sociales__ocultar">YouTube</span>
                            </a>                            
                        <?php }; ?>

                        <?php if($redes->instagram) {; ?>
                            <a class="ponente-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->instagram?>">
                                <span class="ponente-sociales__ocultar">Instagram</span>
                            </a>                            
                        <?php }; ?>

                        <?php if($redes->tiktok) {; ?>
                            <a class="ponente-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->tiktok?>">
                                <span class="ponente-sociales__ocultar">Tik-tok</span>
                            </a>                            
                        <?php }; ?>
                        
                        <?php if($redes->github) {; ?>
                            <a class="ponente-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->github?>">
                                <span class="ponente-sociales__ocultar">Github</span>
                            </a>                            
                        <?php }; ?>

                    </nav>

                    <ul class="ponente__listado-skills">
                        <?php $tags = explode(',', $ponente->tags); ?>
                        <?php foreach ($tags as $tag) { ?>
                            <div class="ponente__skill">
                                <li><?php echo $tag ?></li>
                            </div>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<div id="map" class="mapa">

</div>
