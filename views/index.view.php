   <!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kyngtravels - Paguina principal</title>
    <link rel="icon" type="image/png" href="../assets/logos/SIMBOLO_1.png">
    <!-- CSS only -->
    <link rel="stylesheet" href="../assets/styles/styles.css?v=1">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body style="background:rgba(0, 0, 0, 1);">


      <header class="header nav_bar_size">
        <?php require("components/navbar.php") ?>
      </header>


      <section>
        <?php require("components/carrusel.php") ?>
      </section>



      <footer class="bg-dark text-white">
        <div class="container">
          <div class="row py-1">
            <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                  <img src="assets/logos/SIMBOLO_1.png" alt="" width="100" height="100">
                  <p class="mt-5 mx-5">La pagina Kyngtravels ha sido diseñada con el proposito de dar a nuestros clientes la mejor atencion e informacion sobre sus viajes.</p>
            </div>
            <div class="col-8">
              <div class="row">
                <div class="col-6 col-md-6 col-lg-2 d-flex flex-column justify-content-center align-items-center ">
                  <h5 style="font-family:coolvetiva_rg;">Column</h5>

                </div>
                <div class="col-6 col-md-6 col-lg-2 d-flex flex-column justify-content-center align-items-center">
                  <h5>Column</h5>

                </div>
                <div class="col-6 col-md-6 col-lg-2 d-flex flex-column justify-content-center align-items-center">
                  <h5>Column</h5>

                </div>
                <div class="col-6 col-md-6 col-lg-2 d-flex flex-column justify-content-center align-items-center">
                  <h5>Column</h5>

                </div>
              </div>
            </div>


          </div>
        </div>
      </footer>



      <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>

</html>
