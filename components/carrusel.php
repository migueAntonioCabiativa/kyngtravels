<div id="carouselExampleIndicators" class="carousel slide size_carusel" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <!-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>-->
  </div>
  <div class="carousel-inner h-100">
    <?php for ($i=0; $i < count($carruselInfo); $i++):?>
    <div class="carousel-item <?php if ($i<1):?>active <?php endif; ?> h-100">

      <div style="background:url('assets/img/bg_Cartagena.png') top center no-repeat;background-size: cover;" class="h-100 d-flex flex-column justify-content-center align-items-center bg_carusel" >



        <div class="row container ">

          <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
            <h2 class="mt-3 titulo_carrusel" style="color:white; "><b>CARTAGENA</b></h2>
            <h3><?php echo $titulo; ?></h3>
            <p>¡Sí! Es Cartagena de Indias.</p>
            <p>
Una ciudad que está ubicada a orillas del Mar
Caribe. Sus calles coloridas llenas de encanto la hacen la puerta de entrada a
Suramérica. Esta mágica ciudad es un mundo de mil colores, olores y sabores. Allí donde la arquitectura colonial convive con auténticas obras de arte callejeras y la música se cuela por cada rinconcito de la ciudad..</p>
          </div>
          <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
            <img src="assets/logos/CARTAGENA.png" class="my-5" alt="logo Cartagena" width="80%">
          </div>

        </div>

      </div>


    </div>
  <?php endfor; ?>
    <div class="carousel-item h-100">
      <div class=" h-100 d-flex flex-column justify-content-center align-items-center bg_ejeCafetero bg_carusel">
        <div class="row container ">
          <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
            <h3 class="mt-3" style="color:white; "><b>EJE CAFETERO</b></h3>
            <p>¿quién se quiere perderse este paisaje declarado por la UNESCO como patrimonio de la humanidad?

              El Eje Cafetero es una región geográfica en Colombia donde el Paisaje Cultural Cafetero se extiende a través de los departamentos de Quindío, Caldas y Risaralda, con sus respectivas capitales: Armenia, Manizales y Pereira..</p>
          </div>
          <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
            <img src="assets/logos/EJE_CAFETERO.png" class="my-5" alt="logo Cartagena" width="80%">
          </div>
        </div>
      </div>
    </div>
  <button class="carousel-control-prev" style="width:5%;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" style="width:5%;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
