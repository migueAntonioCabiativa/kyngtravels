<div id="carouselExampleIndicators" class="carousel slide size_carusel" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <?php for ($i=0; $i < count($carruselInfo); $i++):?>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo($i); ?>" <?php if ($i<1):?>class="active" aria-current="true"<?php endif; ?> aria-label="Slide <?php echo(utf8_encode($carruselInfo[$i]['0'])); ?>"></button>
    <?php endfor; ?>
    <!-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>-->
  </div>
  <div class="carousel-inner h-100">
    <?php for ($i=0; $i < count($carruselInfo); $i++):?>
    <div class="carousel-item <?php if ($i<1):?>active <?php endif; ?> h-100">
      <div style="background:url('<?php echo $carruselInfo[$i]['5']; ?>') top center no-repeat;background-size: cover;" class="h-100 d-flex flex-column justify-content-center align-items-center bg_carusel" >
        <div class="row container ">
          <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
            <h2 class="mt-3 titulo_carrusel" style="color:white; "><b><?php echo $carruselInfo[$i]['0']; ?></b></h2>
            <h3><?php echo(utf8_encode($carruselInfo[$i]['1'])); ?></h3>
            <p><?php echo(utf8_encode($carruselInfo[$i]['2'])); ?></p>
            <p><?php echo(utf8_encode($carruselInfo[$i]['3'])); ?></p>
          </div>
          <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
            <img src="<?php echo $carruselInfo[$i]['4']; ?>" class="my-5" alt="logo <?php echo $carruselInfo[$i]['0']; ?>" width="80%">
          </div>
        </div>
      </div>
    </div>
  <?php endfor; ?>
  <button class="carousel-control-prev" style="width:5%;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" style="width:5%;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<style media="screen">


.bg_carusel{
  background-color: rgba(2, 201, 168, 1);
  background-size: cover;
  background-attachment: fixed;
}

.titulo_carrusel{
  font-size: 50px;
}

.size_carusel{
  height:100vh;
}

@media (max-width: 990px) , (max-height: 550px){
  .nav_bar_size{
    height:65px;
  }
}

@media (max-width: 720px){
  .titulo_carrusel{
    font-size: 30px;
  }
}

@media (max-width: 990px){
  .size_carusel{
    height:auto;
  }

  .titulo_carrusel{
    font-size: 40px;
  }

}
</style>
