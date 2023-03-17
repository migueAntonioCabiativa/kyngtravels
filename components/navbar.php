<style media="screen">
@media (max-width: 990px) , (max-height: 400px){
  .nav_bar_size{
    height:65px;
  }
}
</style>

  <nav id="nav_bg" class="navbar fixed-top navbar-expand-md navbar-dark nav_bg" style="background:rgba(45, 45, 45, 0.4);">

    <div class="container-lg">
        <a class="navbar-brand" href="./indexp">
          <img src="assets/logos/imagotipo/HORIZONTAL_BLANCO.png" alt="Logo Kyngtravels" height="35">
        </a>

        <div class="collapse navbar-collapse d-md-flex justify-content-md-end" id="navbarSupportedContent">

          <ul class="navbar-nav me-auto me-md-5 mb-2 mb-lg-0">
            <li class="nav-item px-2">
              <a class="nav-link active" aria-current="page" href="./indexp">Inicio</a>
            </li>
            <li class="nav-item dropdown px-2">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Destinos
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item disabled" href="#">Lugares</a></li>
                <li><a class="dropdown-item disabled" href="#">Tours</a></li>
              </ul>
            </li>
          <li class="nav-item dropdown px-2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Nosotros
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="./Equipo">Equipo</a></li>
              <li><a class="dropdown-item disabled" href="#">Informacion Kyng</a></li>
            </ul>
          </li>
            <li class="nav-item px-2">
              <a class="nav-link disabled">Blogs</a>
            </li>
            <li class="nav-item px-2">
              <a class="nav-link disabled">Test</a>
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
let nav = document.getElementById('nav_bg');
var t = document.getElementsByTagName('title')[0];
console.log("Ancho ventana = " + cw);
if (cw<990) {
  navb(true);
}else {
  navb(false);
}
if (t.text.includes('Equipo')){
  nav.style.setProperty('background', 'rgba(45, 45, 45, 0.4)');
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

    if (r==true ) {
      nav.style.setProperty('backdrop-filter', 'blur(10px)');
      nav.style.setProperty('background', 'rgba(45, 45, 45, 0.4)');
      nav.classList.remove('navbar-light');
      nav.classList.add('navbar-dark');

    }else {
      cw = window.innerWidth;
      if (cw>990 && !(t.text.includes('Equipo'))) {
        nav.style.setProperty('backdrop-filter', 'None');
        nav.style.setProperty('background', 'None');
        if (t.text.includes('Paguina principal')) {
          nav.classList.remove('navbar-dark');
          nav.classList.add('navbar-light');
        }
      }else {
        nav.classList.remove('navbar-light');
        nav.classList.add('navbar-dark');
      }
    }
  }
</script>
