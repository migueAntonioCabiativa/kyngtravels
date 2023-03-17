<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Kyngtravels - Paguina principal</title>
 <link rel="icon" type="image/png" href="../assets/logos/SIMBOLO_1.png">
 <!-- CSS only -->
 <link rel="stylesheet" href="./assets/css/root.css" >
 <link rel="stylesheet" href="./assets/css/loader.css">
 <link rel="stylesheet" href="./assets/styles/styles.css">
 <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

</head>
<body style="background:rgba(0, 0, 0, 1);">

 <div id="splinner" class="contenedor_loader">
     <img class="loader" src="./assets/logos/isotipo/SIMBOLO_1.png" alt="">
 </div>

 <header class="header nav_bar_size">
   <?php require("components/navbar.php") ?>
 </header>

 <section>
   <?php require("components/carrusel.php") ?>
 </section>
<hr style="margin: 0;">
 <section>
   <div class="" style="height:37.5vh; background:var(--color-kyng-blanco);">
     <div class="container" style="">
      <div class="">
        <div class="">
          <h4>que hacer en colombia</h4>
        </div>
        <div class="">

        </div>
      </div>
     </div>
   </div>
 </section>
<hr style="margin: 0;">
   <footer class="bg-dark text-white">
     <div class="container">
       <div class="row py-1">
         <div class="col-4 d-flex flex-column justify-content-center align-items-center">
               <img src="assets/logos/isotipo/SIMBOLO_1.png" alt="" width="100" height="100">
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


   <script src="./assets/js/loader.js"></script>
   <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
