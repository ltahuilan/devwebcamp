<main class="agenda">
    <h2 class="agenda__heading"><?php echo $titulo ?></h2>
    <p class="agenda__descripcion">Talleres y Conferencias dictados por expertos en Desarrollo Web</p>

    <div class="eventos" id="eventos">
        <h3 class="eventos__heading">&lt;Conferencias/></h3>
        <p class="eventos__fecha">Viernes 07 de Julio</p>

        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['conferencias_viernes'] as $evento) { ?>
                    <?php include __DIR__ . '../../templates/eventos.php'; ?>
                <?php } ?>
            </div> <!-- swiper-wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div> <!-- swiper -->

        <p class="eventos__fecha">Sábado 08 de Julio</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['conferencias_sabado'] as $evento) { ?>
                    <?php include __DIR__ . '../../templates/eventos.php'; ?>
                <?php } ?>
            </div> <!-- swiper-wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <div class="eventos eventos--workshops">
        <h3 class="eventos__heading">&lt;Workshops/></h3>
        
        <p class="eventos__fecha">Viernes 07 de Julio</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['workshops_viernes'] as $evento) { ?>
                    <?php include __DIR__ . '../../templates/eventos.php'; ?>
                <?php } ?>
            </div> <!-- swiper-wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="eventos__fecha">Sábado 08 de Julio</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['workshops_sabado'] as $evento) { ?>
                <?php include __DIR__ . '../../templates/eventos.php'; ?>
                <?php } ?>
            </div> <!-- swiper-wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

</main>