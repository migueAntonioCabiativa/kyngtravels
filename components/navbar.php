
  <nav id="nav_bg" class="navbar fixed-top navbar-expand-md navbar-light nav_bg">

    <div class="container-lg">
        <a class="navbar-brand" href="#">
          <img src="assets/logos/LOGO_HORIZONTAL_BLANCO_1_1.png" alt="Logo Kyngtravels" height="35">
        </a>

        <div class="collapse navbar-collapse d-md-flex justify-content-md-end" id="navbarSupportedContent">

          <ul class="navbar-nav me-auto me-md-5 mb-2 mb-lg-0">
            <li class="nav-item px-2">
              <a class="nav-link active" aria-current="page" href="https://Kyngtravels.com">Inicio</a>
            </li>
            <li class="nav-item px-2">
              <a class="nav-link" href="#">Destinos</a>
            </li>
            <!--
            <li class="nav-item dropdown px-2">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Portafolios
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Santa Marta</a></li>
                <li><a class="dropdown-item" href="#">Eje Cafetero</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Tour Personalizado</a></li>
              </ul>
            </li>
          -->
            <li class="nav-item px-2">
              <a class="nav-link" href="#">Nosotros</a>
            </li>
            <li class="nav-item px-2">
              <a class="nav-link disabled">Mapa</a>
            </li>
          </ul>
        </div>
      <button class="navbar-toggler" style="color:white;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


    </div>

  </nav>


<script type="text/javascript">

var cw = window.innerWidth;
var sy = window.scrollY;
console.log("Ancho ventana = " + cw);
if (cw<990) {
  navb(true);
}else {
  navb(false);
}

window.onresize = function() {
  cw = window.innerWidth;
  if (cw<990) {
      navb(true);

    }else {
        navb(false);

    }
};

  window.onscroll = function() {
    sy = window.scrollY;

    //console.log("Scroll = " + sy);
    //console.log("Ancho ventana = " + cw);
    if (sy>20) {
      navb(true);
    }else {
        navb(false);
    }
  };

  function navb(r){
    let nav = document.getElementById('nav_bg');
    if (r==true) {
      nav.style.setProperty('backdrop-filter', 'blur(10px)');
      nav.style.setProperty('background', 'rgba(45, 45, 45, 0.4)');
    }else {
      cw = window.innerWidth;
      if (cw>990) {
        nav.style.setProperty('backdrop-filter', 'None');
        nav.style.setProperty('background', 'None');
      }
    }
  }
</script>
