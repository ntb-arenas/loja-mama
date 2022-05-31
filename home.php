<?php

session_start();
include_once  './login/connect_DB.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma-Ma</title>
    <!-- stylesheet ---------------------------->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.css" rel="stylesheet" />
    <!-- page icon --------------------------------->
    <link rel="shortcut icon" href="gallery/logo.png">
    <!-- fonts ------------------------------------------>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        .disclaimer {
            display: none;
        }
    </style>
</head>

<body>
    <main>
        <?php include_once './components/header.php'; ?>
        <?php include_once './components/navbar.php'; ?>

        <!-- Page cover -->
        <img class="img-fluid mx-auto d-none d-md-block" src="./gallery/maincover.jpg" alt="">
        <img class="img-fluid mx-auto d-none d-sm-block d-md-none" src="./gallery/maincovertabletsize.jpg" alt="">
        <img class="img-fluid mx-auto d-sm-none" src="./gallery/maincovermobilesize.jpg" alt="">
        <!-- Page cover -->

        <div class="container-fluid p-0 border-bottom">
            <h3 class="text-center m-3 cover-message-fs" style="color: rgb(93, 93, 93);">Com a Ma-Ma, a vida da mãe e do seu bebé nunca foi tão fácil. Descubra os nossos produtos!</h3>
        </div>

        <!-- Product Page -->
        <div class="container-fluid px-lg-5 d-none d-sm-block">
            <div class="row mx-lg-n5">
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/almofadas-de-amamentacao">
                        <div class="py-3 border h-100 hover-shadow">
                            <img class="img-fluid" src="gallery/almofadaImg.png" alt="">
                            <h4 class="text-center card-message-fs">ALMOFADAS DE AMAMENTAÇÃO</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/cunhas">
                        <div class="py-3 border h-100 hover-shadow">
                            <img class="img-fluid" src="gallery/cunhas.png" alt="">
                            <h4 class="text-center card-message-fs">CUNHAS</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/slings">
                        <div class="py-3 border h-100 hover-shadow">
                            <img class="img-fluid" src="gallery/slingBebe1.png" alt="">
                            <h4 class="text-center card-message-fs">SLINGS</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/muda-fraldas">
                        <div class="py-3 border h-100 hover-shadow">
                            <img class="img-fluid" src="gallery/mudaFraldas.png" alt="">
                            <h4 class="text-center card-message-fs">MUDA FRALDAS</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/kit-maternidade">
                        <div class="py-3 border h-100 hover-shadow">
                            <img class="img-fluid" src="gallery/kitMaternidadeAzul.png" alt="">
                            <h4 class="text-center card-message-fs">KIT MATERNIDADE</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/almofadas-anticolicas">
                        <div class="py-3 border h-100 hover-shadow">
                            <img class="img-fluid" src="gallery/antiColicas.png" alt="">
                            <h4 class="text-center card-message-fs">ALMOFADAS ANTI-CÓLICAS</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="container-fluid px-lg-5 d-block d-sm-none">
            <div class="row mx-lg-n5">
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/almofadas-de-amamentacao" class="text-decoration-none" style="font-size: calc(0.5rem + .3vw); color: rgb(40, 40, 40);" role="button">
                        <div class="border h-100">
                            <img class="img-fluid" src="gallery/almofadaImg.png" alt="">
                            <h4 class="text-center card-message-fs">ALMOFADAS DE AMAMENTAÇÃO</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/cunhas" class="text-decoration-none" style="font-size: calc(0.5rem + .3vw); color: rgb(40, 40, 40);" role="button">
                        <div class="border h-100">
                            <img class="img-fluid" src="gallery/cunhas.png" alt="">
                            <h4 class="text-center card-message-fs">CUNHAS</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/slings" class="text-decoration-none" style="font-size: calc(0.5rem + .3vw); color: rgb(40, 40, 40);" role="button">
                        <div class="border h-100">
                            <img class="img-fluid" src="gallery/slingBebe1.png" alt="">
                            <h4 class="text-center card-message-fs">SLINGS</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/muda-fraldas" class="text-decoration-none" style="font-size: calc(0.5rem + .3vw); color: rgb(40, 40, 40);" role="button">
                        <div class="border h-100">
                            <img class="img-fluid" src="gallery/mudaFraldas.png" alt="">
                            <h4 class="text-center card-message-fs">MUDA FRALDAS</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/kit-maternidade" class="text-decoration-none" style="font-size: calc(0.5rem + .3vw); color: rgb(40, 40, 40);" role="button">
                        <div class="border h-100">
                            <img class="img-fluid" src="gallery/kitMaternidadeAzul.png" alt="">
                            <h4 class="text-center card-message-fs">KIT MATERNIDADE</h4>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-sm-6 col-md-4 py-3 px-lg-3">
                    <a href="./product/almofadas-anticolicas" class="text-decoration-none" style="font-size: calc(0.5rem + .3vw); color: rgb(40, 40, 40);" role="button">
                        <div class="border h-100">
                            <img class="img-fluid" src="gallery/antiColicas.png" alt="">
                            <h4 class="text-center card-message-fs">ALMOFADAS ANTI-CÓLICAS</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>


        <section class="gradient-custom ">
            <div class="container ">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12">
                        <div class="text-center">
                            <i class="fas fa-quote-left fa-3x text-white"></i>
                        </div>
                        <div class="card">
                            <div class="card-body px-4 py-5">
                                <!-- Carousel wrapper -->
                                <div id="carouselDarkVariant" class="carousel slide" data-mdb-interval="false">
                                    <!-- Indicators -->
                                    <div class="carousel-indicators mb-0">
                                        <?php
                                        $num = 0;
                                        $slideNum = 1;
                                        $result = mysqli_query($_conn, "SELECT * FROM REVIEWS");
                                        while ($row = mysqli_fetch_array($result)) {
                                            if ($row['CODE'] == '1') {
                                                echo '
                                            <button data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="' . $num . '" class="active theme-background-color" aria-current="true" aria-label="Slide ' . $slideNum . '"></button>
                                            ';
                                            } else {
                                                $num = $num + 1;
                                                $slideNum = $slideNum + 1;
                                                echo '
                                                <button class="theme-background-color" data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="' . $num . '" aria-label="Slide ' . $slideNum . '"></button>';
                                            }
                                        }
                                        ?>
                                    </div>

                                    <!-- Inner -->
                                    <div class="carousel-inner pb-5">
                                        <!-- Single item -->
                                        <?php
                                        $result = mysqli_query($_conn, "SELECT * FROM REVIEWS");
                                        while ($row = mysqli_fetch_array($result)) {
                                            if ($row['CODE'] == '1') {
                                                echo '
                                                <div class="carousel-item active">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-lg-10 col-xl-8">
                                                            <div class="row">
                                                                <div class="col-md-4 col-lg-4 d-flex justify-content-center">
                                                                    <img src="' . $row['IMAGE_URL'] . '" class="rounded-8 shadow-1 mb-4 mb-lg-0" width="200"
                                                                    height="200"/>
                                                                </div>
                                                                <div class="col-9 col-md-8 col-lg-7 col-xl-8 text-center text-lg-start mx-auto mx-lg-0">
                                                                    <h4 class="mb-4">' . $row['NAME'] . '</h4>
                                                                    <p class="mb-0 pb-3">
                                                                    ' . $row['DESCRIPTION'] . '
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                            } else {
                                                echo '
                                                <div class="carousel-item">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-lg-10 col-xl-8">
                                                            <div class="row">
                                                               <div class="col-md-4 col-lg-4 d-flex justify-content-center">
                                                                   <img src="' . $row['IMAGE_URL'] . '" class="rounded-8 shadow-1 mb-4 mb-lg-0" width="200"
                                                                   height="200" />
                                                                </div>
                                                                <div class="col-9 col-md-8 col-lg-7 col-xl-8 text-center text-lg-start mx-auto mx-lg-0">
                                                                    <h4 class="mb-4">' . $row['NAME'] . '</h4>
                                                                    <p class="mb-0 pb-3">
                                                                    ' . $row['DESCRIPTION'] . '
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                            }
                                        }
                                        ?>
                                        <!-- Single item -->
                                    </div>
                                    <!-- Inner -->

                                    <!-- Controls -->
                                    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="prev">
                                        <span class="carousel-control-prev-icon theme-color"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next " type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="next">
                                        <span class="carousel-control-next-icon theme-color"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <!-- Carousel wrapper -->
                            </div>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-quote-right fa-3x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Page -->

        <?php include_once './components/footer.php'; ?>
    </main>
</body>
<!-- <script src="./bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>