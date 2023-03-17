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
      <div style="background:url('./assets/logos/fondos/<?php echo $carruselInfo[$i]['5']; ?>') top center no-repeat;background-size: cover;" class="d-flex justify-content-center align-items-center bg_carusel h-100">
        <div class="container container-xxl contenido_carrusel">
          <div class=" d-flex flex-column justify-content-center align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center">
              <div class="">
                <h2 class="titulo_carrusel" style="color:var(<?php echo $carruselInfo[$i]['6']; ?>); "><?php echo $carruselInfo[$i]['0']; ?></h2>
                <h3 class="tema_carrusel" style="color:var(<?php echo $carruselInfo[$i]['6']; ?>);"><?php echo(utf8_encode($carruselInfo[$i]['1'])); ?></h3>
              </div>
              <div class="frase_viaja" style="background-color:var(<?php echo $carruselInfo[$i]['7']; ?>);">
                <h5>VIAJA CON NOSOTROS</h5>
              </div>
            </div>
            <div class="info_carrusel_1">
              <p style="color:var(<?php echo $carruselInfo[$i]['8'];?>);text-align: justify;"><?php echo(utf8_encode($carruselInfo[$i]['3']));?></p>
              <a href="" class="btn btn-brand me-3" style="color:var(<?php echo $carruselInfo[$i]['6']; ?>);">Explore My Work</a>
            </div>

          </div>
          <div class="d-flex flex-column justify-content-center align-items-center">
            <img src="./assets/logos/tematicos/<?php echo $carruselInfo[$i]['4']; ?>" class="logo_carrusel" alt="logo <?php echo $carruselInfo[$i]['0']; ?>">
          </div>
          <div class="info_carrusel_2">
            <p style="color:var(<?php echo $carruselInfo[$i]['8'];?>);text-align:justify;"><?php echo(utf8_encode($carruselInfo[$i]['3'])); ?></p>
            <a href="" class="btn btn-brand me-3" style="color:var(<?php echo $carruselInfo[$i]['6']; ?>);">Explore My Work</a>
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

.contenido_carrusel{
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.titulo_carrusel{
  margin: 0;
  font-family: 'OpenSansSemiBold';
  line-height: 0.8;
  text-align: center;
}

.tema_carrusel{
  margin: 0;
  font-family: 'OpenSansLight';
  text-align: center;
}

.info_carrusel_1{
  display: none;
}
.info_carrusel_2{
  display: none;
}

.frase_viaja{
  padding: 0px 15px;
  margin-bottom: 15px;
}

.frase_viaja h5{
  margin: 0;
  color: white;
}

.btn {
    padding: 8px 20px;
    font-weight: 700;
}

.btn-brand {
    background-color: var(--color-shadow);
    border-color: var(--color-brand);

}

.btn-brand:hover,
.btn-brand:focus {
    background-color: var(--color-brand);
    color: var(--color-base);
    border-color: var(--color-brand2);
}
p{
    font-family: 'OpenSans';
}

@media (max-width: 767px) and (orientation: portrait){
  .size_carusel{
    height:calc(100vh - 65px);
  }
  .titulo_carrusel{
    font-size: calc(1.2em + 2.6vh);
  }
  .logo_carrusel{
    height: 30vh;
  }
  .contenido_carrusel{
    flex-direction: column;
  }
  .info_carrusel_2{
    display: block;
    width: 98%;
  }
  .info_carrusel_2 p{
      font-size: calc(0.6em + 0.5vh);
  }
}
@media (max-width: 767px) and (orientation: landscape){
  .size_carusel{
    height:calc(100vh - 65px);
  }
  .titulo_carrusel{
    font-size: 30px;
  }
  .logo_carrusel{
    height: 30vh;
  }
  .info_carrusel_1{
    display: block;
    width: 80%;
  }
  .info_carrusel_1 p{
      font-size: calc(0.5em + 0.45vw);
  }
}


@media (min-width: 768px) and (max-width: 990px) and (orientation: portrait){
  .size_carusel{
    height:calc(100vh - 65px);
  }
  .titulo_carrusel{
    font-size: calc(1em + 5vw);
  }
  .tema_carrusel{
    font-size: calc(1em + 4.5vw);
  }

  .logo_carrusel{
    height: 40vh;
  }
  .contenido_carrusel{
    flex-direction: column;
  }
  .info_carrusel_2{
    display: block;
    width: 90%;
  }
  .info_carrusel_2 p{
      font-size: calc(0.9em + 0.5vh);
  }
}

@media (min-width: 768px) and (max-width: 990px) and (orientation: landscape){
  .size_carusel{
    height:calc(100vh - 65px);
  }

  .titulo_carrusel{
    font-size: calc(1em + 3vw);
  }
  .tema_carrusel{
    font-size: calc(1em + 2.5vw);
  }
  .logo_carrusel{
    height: 50vh;
  }
  .contenido_carrusel{
    flex-direction: row;
  }
  .info_carrusel_1{
    display: block;
    width: 90%;
  }
  .info_carrusel_1 p{
      font-size: calc(0.6em + 0.5vw);
  }

}


@media (min-width: 990px) and (max-width: 1500px){
  .size_carusel{
    height:100vh;
  }

  .titulo_carrusel{
    font-size: calc(1.3em + 3vw);
  }
  .tema_carrusel{
    font-size: calc(1em + 2vw);
  }
  .logo_carrusel{
    width: 40vw;
  }

  .info_carrusel_1{
    display: block;
    width: 80%;
  }

  .info_carrusel_1 p{
      font-size: calc(0.8em + 0.3vw);
  }
}

@media (min-width: 1501px){
    .size_carusel{
      height:100vh;
    }

    .titulo_carrusel{
      font-size: calc(1.3em + 3vw);
    }
    .tema_carrusel{
      font-size: calc(1em + 2vw);
    }
    .logo_carrusel{
      height: 60vh;
    }

    .info_carrusel_1{
      display: block;
      width: 95%;
    }

    .info_carrusel_1 p{
        font-size: calc(0.5em + 0.6vw);
    }

}
</style>
