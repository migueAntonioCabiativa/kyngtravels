<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/aos.css">
    <link rel="stylesheet" href="./assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/persona.css">
  </head>
  <body data-bs-spy="scroll" data-bs-target=".navbar">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container flex-lg-column">
            <a class="navbar-brand mx-lg-auto mb-lg-4" href="#">
                <div class="d-block d-lg-none">
                  <img src="./assets/logos/LOGO_HORIZONTAL_BLANCO_1_1.png" class="" alt="Logo Kyngtravels" height="30"> <span class="h3 fw-bold"> - <?php echo $home["FirstName"]; ?></span>
                </div>
                <img src="./assets/Fotos/<?php echo $home["User"]?>.jpeg" class="d-none d-lg-block rounded-circle" alt="Foto">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto flex-lg-column text-lg-center">

                    <li class="nav-item" style=" <?php if (!$home){ echo 'display: None';} ?>">
                        <a class="nav-link" href="#home">inicio</a>
                    </li>
                    <li class="nav-item" style=" <?php if (!$services){ echo 'display: None';} ?>">
                        <a class="nav-link" href="#services">Servicios</a>
                    </li>
                    <li class="nav-item" style=" <?php if (!$experiance){ echo 'display: None';} ?>">
                        <a class="nav-link" href="#experiance">Experiencia</a>
                    </li>
                    <li class="nav-item" style=" <?php if (!$about){ echo 'display: None';} ?>">
                        <a class="nav-link" href="#about">Sobre mi</a>
                    </li>
                    <li class="nav-item" style=" <?php if (!$reviews){ echo 'display: None';} ?>">
                        <a class="nav-link" href="#reviews">Recomendaciones</a>
                    </li>
                    <li class="nav-item" style=" <?php if (!$blog){ echo 'display: None';} ?>">
                        <a class="nav-link" href="#blog">Mi Blog</a>
                    </li>
                    <li class="nav-item" style=" <?php if (!$contact){ echo 'display: None';} ?>">
                        <a class="nav-link" href="#contact">Contactame</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- //NAVBAR -->

    <!-- CONTENT WRAPPER -->
    <div id="content-wrapper">

        <!-- HOME -->
        <section id="home" class="full-height px-lg-5" style=" <?php if (!$home){ echo 'display: None';} ?>">

            <div class="container">
                <div class="row">
                    <div class="col-lg-10">
                        <h2 class="display-5 fw-bold" data-aos="fade-up"><?php echo ucfirst($home["FirstName"]).' '.ucfirst(substr($home["MiddleName"], 0, 1)).'. '; ?> <span class="text-brand"><?php echo ucfirst($home["FirstSurname"]).' '.ucfirst($home["SecondSurname"]); ?> </span></h2>
                        <p class="lead mt-2 mb-4" data-aos="fade-up" data-aos-delay="300"><?php echo utf8_encode($home['PersonText'])?></p>
                        <div data-aos="fade-up" data-aos-delay="600">
                            <a href="#work" class="btn btn-brand me-3">Explore My Work</a>
                            <a href="#" class="link-custom">Call: (+57) 317 506 7139</a>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- //HOME -->

        <!-- SERVICES -->
        <section id="services" class="full-height px-lg-5" style=" <?php if (!$Services){ echo 'display: None';} ?>">
            <div class="container">

                <div class="row pb-4" data-aos="fade-up">
                    <div class="col-lg-8">
                        <h6 class="text-brand">SERVICES</h6>
                        <h1>Services That I Provide</h1>
                    </div>
                </div>

                <div class="row gy-4">

                    <div class="col-md-4" data-aos="fade-up">
                        <div class="service p-4 bg-base rounded-4 shadow-effect">
                            <div class="iconbox rounded-4">
                                <i class="las la-feather"></i>
                            </div>
                            <h5 class="mt-4 mb-2">UX Design</h5>
                            <p>I craft high-performing and delightful experiences tailored and conversion-focused</p>
                            <a href="#" class="link-custom">Read More</a>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="service p-4 bg-base rounded-4 shadow-effect">
                            <div class="iconbox rounded-4">
                                <i class="las la-pencil-ruler"></i>
                            </div>
                            <h5 class="mt-4 mb-2">Branding</h5>
                            <p>I craft high-performing and delightful experiences tailored and conversion-focused</p>
                            <a href="#" class="link-custom">Read More</a>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                        <div class="service p-4 bg-base rounded-4 shadow-effect">
                            <div class="iconbox rounded-4">
                                <i class="las la-laptop-code"></i>
                            </div>
                            <h5 class="mt-4 mb-2">Web Designing</h5>
                            <p>I craft high-performing and delightful experiences tailored and conversion-focused</p>
                            <a href="#" class="link-custom">Read More</a>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- SERVICES -->

        <!-- WORK -->
        <section id="work" class="full-height px-lg-5" style=" <?php if (!$work){ echo 'display: None';} ?>">
            <div class="container">

                <div class="row pb-4" data-aos="fade-up">
                    <div class="col-lg-8">
                        <h6 class="text-brand">WORK</h6>
                        <h1>My Recent Projects</h1>
                    </div>
                </div>

                <div class="row gy-4">

                    <div class="col-md-6" data-aos="fade-up">
                        <div class="card-custom rounded-4 bg-base shadow-effect">
                            <div class="card-custom-image rounded-4">
                                <img class="rounded-4" src="./assets/img/project-1.jpg" alt="">
                            </div>
                            <div class="card-custom-content p-4">
                                <h4>Startup Landing Page</h4>
                                <p>Innovation that exceeds expectations. Astra is a true template equiqed with all the elements you could ever need to put together</p>
                                <a href="#" class="link-custom">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-custom rounded-4 bg-base shadow-effect">
                            <div class="card-custom-image rounded-4">
                                <img class="rounded-4" src="./assets/img/project-2.png" alt="">
                            </div>
                            <div class="card-custom-content p-4">
                                <h4>Startup Landing Page</h4>
                                <p>Innovation that exceeds expectations. Astra is a true template equiqed with all the elements you could ever need to put together</p>
                                <a href="#" class="link-custom">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" data-aos="fade-up">
                        <div class="card-custom rounded-4 bg-base shadow-effect">
                            <div class="card-custom-image rounded-4">
                                <img class="rounded-4" src="./assets/img/project-3.png" alt="">
                            </div>
                            <div class="card-custom-content p-4">
                                <h4>Startup Landing Page</h4>
                                <p>Innovation that exceeds expectations. Astra is a true template equiqed with all the elements you could ever need to put together</p>
                                <a href="#" class="link-custom">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-custom rounded-4 bg-base shadow-effect">
                            <div class="card-custom-image rounded-4">
                                <img class="rounded-4" src="./assets/img/project-4.png" alt="">
                            </div>
                            <div class="card-custom-content p-4">
                                <h4>Startup Landing Page</h4>
                                <p>Innovation that exceeds expectations. Astra is a true template equiqed with all the elements you could ever need to put together</p>
                                <a href="#" class="link-custom">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- //WORK -->

        <!-- EXPERIENCE -->
        <section id="experiance" class="full-height px-lg-5" style=" <?php if (!$experiance){ echo 'display: None';} ?>">
            <div class="container">
                <div class="row pb-4" data-aos="fade-up">
                    <div class="col-lg-8">
                        <h6 class="text-brand">Experiance</h6>
                        <h2>Mi experiencia laboral</h2>
                    </div>
                </div>
                <div class="row gy-5">
                    <div class="col-lg-12">
                        <div class="row gy-4">
                            <div class="col-12 col-lg-6" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Applications developer</h4>
                                    <p class="text-brand mb-2">Twitter (2018 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Applications developer</h4>
                                    <p class="text-brand mb-2">Twitter (2018 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Applications developer</h4>
                                    <p class="text-brand mb-2">Twitter (2018 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Applications developer</h4>
                                    <p class="text-brand mb-2">Twitter (2018 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- //EXPERIENCE -->

        <!-- ABOUT -->
        <section id="about" class="full-height px-lg-5" style=" <?php if (!$about){ echo 'display: None';} ?>">
            <div class="container">

                <div class="row pb-4" data-aos="fade-up">
                    <div class="col-lg-8">
                        <h6 class="text-brand">ABOUT</h6>
                        <h1>My Education & Experiance</h1>
                    </div>
                </div>

                <div class="row gy-5">
                    <div class="col-lg-6">

                        <h3 class="mb-4" data-aos="fade-up" data-aos-delay="300">Education</h3>
                        <div class="row gy-4">

                            <div class="col-12" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Master of Software Engineering</h4>
                                    <p class="text-brand mb-2">De Mars University Venston Bay (2015 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>

                            <div class="col-12" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Master of Software Engineering</h4>
                                    <p class="text-brand mb-2">De Mars University Venston Bay (2015 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>

                            <div class="col-12" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Master of Software Engineering</h4>
                                    <p class="text-brand mb-2">De Mars University Venston Bay (2015 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <h3 class="mb-4" data-aos="fade-up" data-aos-delay="300">Experiance</h3>
                        <div class="row gy-4">

                            <div class="col-12" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Applications developer</h4>
                                    <p class="text-brand mb-2">Twitter (2018 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>

                            <div class="col-12" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Applications developer</h4>
                                    <p class="text-brand mb-2">Twitter (2018 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>

                            <div class="col-12" data-aos="fade-up" data-aos-delay="600">
                                <div class="bg-base p-4 rounded-4 shadow-effect">
                                    <h4>Applications developer</h4>
                                    <p class="text-brand mb-2">Twitter (2018 - 2020)</p>
                                    <p class="mb-0">All we are more and design lorem ipsum dolor creativity sit amet consectetur adipisicing elit</p>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </section>
        <!-- //ABOUT -->

        <!-- REVIEWS -->
        <section id="reviews" class="full-height px-lg-5" style=" <?php if (!$reviews){ echo 'display: None';} ?>">
            <div class="container">

                <div class="row pb-4" data-aos="fade-up">
                    <div class="col-lg-8">
                        <h6 class="text-brand">REVIEWS</h6>
                        <h1>What our subscribers say</h1>
                    </div>
                </div>

                <div class="row gy-4">

                    <div class="col-md-4" data-aos="fade-up">

                        <div class="review shadow-effect bg-base p-4 rounded-4">
                            <div class="text-brand h5">
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                            </div>
                            <p class="my-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel quae facilis fugiat molestias ab illum excepturi, qui optio modi asperiores, delectus maiores!</p>
                            <div class="person">
                                <h5 class="mb-0">Jon Doe</h5>
                                <p class="mb-0">Twitter</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">

                        <div class="review shadow-effect bg-base p-4 rounded-4">
                            <div class="text-brand h5">
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                            </div>
                            <p class="my-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel quae facilis fugiat molestias ab illum excepturi, qui optio modi asperiores, delectus maiores!</p>
                            <div class="person">
                                <h5 class="mb-0">Jon Doe</h5>
                                <p class="mb-0">Twitter</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">

                        <div class="review shadow-effect bg-base p-4 rounded-4">
                            <div class="text-brand h5">
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                            </div>
                            <p class="my-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel quae facilis fugiat molestias ab illum excepturi, qui optio modi asperiores, delectus maiores!</p>
                            <div class="person">
                                <h5 class="mb-0">Jon Doe</h5>
                                <p class="mb-0">Twitter</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>
        <!-- //REVIEWS -->

        <!-- BLOG -->
        <section id="blog" class="full-height px-lg-5" style="<?php if (!$blog){ echo 'display: None';} ?>">
            <div class="container">

                <div class="row pb-4" data-aos="fade-up">
                    <div class="col-lg-8">
                        <h6 class="text-brand">BLOG</h6>
                        <h1>My BLog Posts</h1>
                    </div>
                </div>

                <div class="row gy-4">

                    <div class="col-md-4" data-aos="fade-up">
                        <div class="card-custom rounded-4 bg-base shadow-effect">
                            <div class="card-custom-image rounded-4">
                                <img class="rounded-4" src="./assets/img/blog-post-1.jpg" alt="">
                            </div>
                            <div class="card-custom-content p-4">
                                <p class="text-brand mb-2">20 Dec, 2022</p>
                                <h5 class="mb-4">Design a creative landing page using Bootstrap 5</h5>
                                <a href="#" class="link-custom">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-custom rounded-4 bg-base shadow-effect">
                            <div class="card-custom-image rounded-4">
                                <img class="rounded-4" src="./assets/img/blog-post-2.jpg" alt="">
                            </div>
                            <div class="card-custom-content p-4">
                                <p class="text-brand mb-2">20 Dec, 2022</p>
                                <h5 class="mb-4">Design a creative landing page using Bootstrap 5</h5>
                                <a href="#" class="link-custom">Read More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                        <div class="card-custom rounded-4 bg-base shadow-effect">
                            <div class="card-custom-image rounded-4">
                                <img class="rounded-4" src="./assets/img/blog-post-3.jpg" alt="">
                            </div>
                            <div class="card-custom-content p-4">
                                <p class="text-brand mb-2">20 Dec, 2022</p>
                                <h5 class="mb-4">Design a creative landing page using Bootstrap 5</h5>
                                <a href="#" class="link-custom">Read More</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- //BLOG -->

        <!-- CONTACT -->
        <section id="contact" class="full-height px-lg-5" style=" <?php if (!$contact){ echo 'display: None';} ?>">
            <div class="container">

                <div class="row justify-content-center text-center">
                    <div class="col-lg-8 pb-4" data-aos="fade-up">
                        <h6 class="text-brand">CONTACTO</h6>
                        <h2>¿Deseas mas informacion? ¿Estas interesado en trabajar con nosotros? ¡Contactanos!</h2>
                    </div>

                    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="300">
                        <form action="#" class="row g-lg-3 gy-3">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" placeholder="Escribe tu nombre">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control" placeholder="Escribe tu Correo">
                            </div>
                            <div class="form-group col-12">
                                <input type="text" class="form-control" placeholder="Escribe el objeto">
                            </div>
                            <div class="form-group col-12">
                                <textarea name="" rows="4" class="form-control" placeholder="Escribe un mensaje"></textarea>
                            </div>
                            <div class="form-group col-12 d-grid">
                                <button type="submit" class="btn btn-brand">Contactame</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </section>
        <!-- //CONTACT -->

        <!-- FOOTER -->
        <footer class="py-5 px-lg-5">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-auto">
                        <div class="social-icons">
                          <?php if (utf8_encode($home["Facebook"])!=''): ?>
                            <a href="https://www.facebook.com/<?php echo $home["Facebook"];?>" target="_blank"><i class="lab la-facebook"></i></a>
                          <?php endif;
                           if (utf8_encode($home["Instagram"])!=''): ?>
                            <a href="https://www.instagram.com/<?php echo $home["Instagram"];?>" target="_blank"><i class="lab la-instagram"></i></a>
                          <?php endif; ?>
                          <!--
                            <a href="#"><i class="lab la-twitter"></i></a>
                            <a href="#"><i class="lab la-dribbble"></i></a>
                            <a href="#"><i class="lab la-github"></i></a>
                          -->
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- //FOOTER -->

    </div>
    <!-- //CONTENT WRAPPER -->


    <script type="text/javascript" src="./assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="./assets/js/aos.js"></script>
    <script type="text/javascript" src="./assets/js/persona.js"></script>
  </body>
</html>
