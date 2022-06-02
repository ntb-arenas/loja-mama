<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  '../login/connect_DB.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma-Ma</title>
    <!-- stylesheet ---------------------------->
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.css" rel="stylesheet" />
    <!-- page icon --------------------------------->
    <link rel="shortcut icon" href="../gallery/logo.png">
    <!-- fonts ------------------------------------------>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>

    <?php include_once '../components/header.php'; ?>
    <?php include_once '../components/navbar.php'; ?>
    <main>
        <div class="bg-image d-none d-sm-block">
            <img src="../gallery/family.png" class="img-fluid" alt="">
            <div class="mask">
                <div class="row">
                    <div class="col-6 text-center">
                        <h1 class="fst-italic text-white display-1" style="font-weight: 600;">MA-MA®</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mx-3 text-center lh-sm" style="font-weight: 300; font-size: 2rem;">
                        <p class="text-white">A MA-MA® foi criada em 2006 com o intuito de apoiar as mamãs na gravidez e após o nascimento do bebé, disponibilizando uma vasta gama de produtos pensados especificamente para responder às necessidades de pais e bebé.</p>
                    </div>
                </div>
            </div>
            </img>
        </div>

        <div class="bg-image d-sm-none">
            <img src="../gallery/family-small.png" class="img-fluid" alt="">
            <div class="mask">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="fst-italic text-white display-1" style="font-weight: 600;">MA-MA®</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center lh-sm" style="font-weight: 300; font-size: 1.3rem;">
                        <p class="text-white copy1">A MA-MA® foi criada em 2006 com o intuito de apoiar as mamãs na gravidez e após o nascimento do bebé, disponibilizando uma vasta gama de produtos pensados especificamente para responder às necessidades de pais e bebé.</p>
                    </div>
                </div>
            </div>
            </img>
        </div>


        <!-- <div class="bg-image">
            <img src="../gallery/family.png" class="img-fluid" alt="Sample" />
            <div class="mask d-flex align-items-center" style="background-color: rgba(0, 0, 0, 0.3);">
                <div class="container text-center">
                    <h1 class="fst-italic text-white" style="font-weight: 800; font-size: 3rem;">Quem Somos</h1>
                </div>
                <div class="container">
                    <p class="text-white">A MA-MA® foi criada em 2006 com o intuito de apoiar as mamãs na gravidez e após o nascimento do bebé, disponibilizando uma vasta gama de produtos pensados especificamente para responder às necessidades de pais e bebé.</p>
                </div>
            </div>
        </div> -->
    </main>
    <?php include_once '../components/footer.php'; ?>
</body>
<script src="../js/script.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>