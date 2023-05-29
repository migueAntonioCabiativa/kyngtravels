<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Kyngtravels - Equipo</title>
    <link rel="icon" type="image/png" href="assets/logos/SIMBOLO_1.png">
    <link rel="stylesheet" href="./assets/css/root.css">
    <link rel="stylesheet" href="./assets/css/loader.css">
    <link rel="stylesheet" href="./assets/css/aos.css">
    <link rel="stylesheet" href="./assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/QR.css">
    <link rel="stylesheet" href="./assets/css/PersonCard.css" >

  </head>

  <style media="screen">
    body {
        background: var(--color-grad-1);
        background-attachment: fixed;
        color: var(--color-body);
    }
  </style>

  <body>
    <div id="splinner" class="contenedor_loader">
        <img class="loader" src="./assets/logos/isotipo/SIMBOLO_1.png" alt="">
    </div>
    <header class="header">
      <?php require("./components/navbar.php"); ?>
    </header>

    <section class="container section_full">
        <h2 style="text-align:center; font-size:calc(1em + 5.1vw);color:var(--color-equipo-title);font-family:'coolvetica rg'; text-shadow: 11px 10px 8px rgba(0, 0, 0, 0.6);">Nuestro Increible Equipo</h2>
    </section>

    <section class="container section_full">
      <div class="row">
        <div class=" w-100 titulos_Kyng" style="position:relative;">
          <div style="position:absolute;top: 30px;">
            <h2 style="text-align:center;font-size:calc(1.3em + 3vw);color: #f1f1f1;;font-family:'coolveticarg'; text-shadow: 11px 10px 8px rgba(0, 0, 0, 0.6);">VIAJEROS APACIONADOS</h2>
          </div>
          <div style="position:absolute;">
            <h2 style="text-align:center;font-size:calc(1em + 3vw);color: #f8be00;font-family:'breathing';">Planners Travels</h2>
          </div>
        </div>

        <?php for ($i=0; $i < count($Personas); $i++):?>
          <div class="d-flex justify-content-center align-items-center">
            <div class="Kyng-card p-2 mx-4 rounded-2 d-flex flex-column align-items-center" style="min-width:200px; width:25vw; max-width:350px;z-index:5;">
              <div class="Card-location-img">
                <img src="./assets/Fotos/<?php echo $Personas[$i]['1'];?>.jpeg" class="card-img rounded-circle" alt="<?php echo $Personas[$i]['1'];?>">
                <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                	 width="100%" height="100%" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                <g>
                	<path fill="#231F20" d="M32,0C18.745,0,8,10.745,8,24c0,5.678,2.502,10.671,5.271,15l17.097,24.156C30.743,63.686,31.352,64,32,64
                		s1.257-0.314,1.632-0.844L50.729,39C53.375,35.438,56,29.678,56,24C56,10.745,45.255,0,32,0z M32,38c-7.732,0-14-6.268-14-14
                		s6.268-14,14-14s14,6.268,14,14S39.732,38,32,38z"/>
                </g>
                </svg>

              </div>
              <div class="Kyng-card-body">
                <h5 class="Kyng-card-name text-center mb-1"><?php echo ucfirst($Personas[$i]['2']).' '.ucfirst($Personas[$i]['4'])?></h5>
                <p class="Kyng-card-text text-center"><?php echo utf8_encode($Personas[$i]['13'])?></p>
                <div class="Kyng-card-social mt-1 mb-1 ">
                  <?php if ($Personas[$i]['11'] != NULL): ?>
                    <a href="https://www.instagram.com/<?php echo $Personas[$i]['11'];?>" class="mx-1" target="_blank"><i class="lab la-instagram"></i></a>
                  <?php endif; ?>
                  <?php if ($Personas[$i]['12'] != NULL): ?>
                    <a href="https://www.facebook.com/<?php echo $Personas[$i]['12'];?>" class="mx-1" target="_blank"><i class="lab la-facebook"></i></a>
                  <?php endif; ?>
                </div>
                <div class="d-flex justify-content-center">
                  <a href="./Persona?User=<?php echo $Personas[$i]['1']; ?>" class="link-custom mt-1 mx-3">Leer mas</a>
                </div>
              </div>
            </div>
          <?php endfor; ?>

          <div class="position-absolute" style="width:100vw; height:10vh; z-index:1; display:none;"></div>
        </div>
      </div>

    </section>

    <button onclick="StarScanner();" class="bottomQR QR">
         <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc.--><path d="M48 32C21.5 32 0 53.5 0 80v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H48zm80 64v64H64V96h64zM48 288c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48zm80 64v64H64V352h64zM256 80v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H304c-26.5 0-48 21.5-48 48zm64 16h64v64H320V96zm32 352v32h32V448H352zm96 0H416v32h32V448zM416 288v32H352V288H256v96 96h64V384h32v32h96V352 320 288H416z"/></svg>
     </button>

     <div id="modal_container" class="modal-container">
       <a onclick="StopScanner();"></a>
       <div class="modalQR">
         <div id="reader" class="scanning" ></div>
         <button onclick="StopScanner();" class="bottomQR">Cerrar</button>
       </div>
     </div>
    <script src="./assets/js/loader.js"></script>
    <script src="./layouts/html5-qrcode/html5-qrcode.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="./assets/js/aos.js"></script>
    <script src="./assets/js/QR.js" type="text/javascript"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
