<?php
session_start();

include_once  '../login/connect_DB.php';

if (!isset($_SESSION["USER"])) {
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
    header("Location: /error-pages/403-proibido");
}
if ($_SESSION['ADMIN'] == 1) {
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
    header("Location: /error-pages/403-proibido");
}

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
    <style>
        .disclaimer {
            display: none;
        }
    </style>
</head>

<body>
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-dark">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="dashboard" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color" aria-current="true" style>
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
                    </a>
                </div>
            </div>
        </nav>
        <!-- Sidebar -->

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light theme-background-color fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <!-- Brand -->
                <a class="navbar-brand p-0" href="../home">
                    <img src="../gallery/logo-white.png" height="50" alt="" loading="lazy" />
                </a>
                <!-- Right links -->
                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <!-- Avatar -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center ripple" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <img src="../gallery/admin/me.jpg" class="rounded-circle" height="35" width="35" alt="" loading="lazy" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">My profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="../login/usersair.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </header>
    <main class="main-admin" style="margin-top: 58px">
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="container-fluid border p-3 h-100">
                        <div class="container-fluid text-center">
                            <img src="../gallery/admin/me.jpg" class="rounded-circle img-fluid" width="200" alt="">
                        </div>
                        <div class="container-fluid text-center pt-3 border-bottom">
                            <h3 class="m-0">Niño Arenas</h3>
                            <p>Admin</p>
                        </div>
                        <div class="container-fluid pt-3 px-0 px-xl-3">
                            <p class="m-0" style="color: #acacac;">Correio eletrônico</p>
                            <p>ntbarenas@gmail.com</p>
                            <p class="m-0" style="color: #acacac;">Telemóvel</p>
                            <p>+351 999 999 999</p>
                        </div>
                        <div class="container-fluid px-0 px-lg-3">
                            <p class="m-0" style="color: #acacac;">Social</p>
                            <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998;" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-floating m-1" style="background-color: #55acee;" href="#!" role="button"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-floating m-1 gradient-insta" href="#!" role="button"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8 mt-3 mt-md-0">
                    <div class="container-fluid border p-3 h-100">
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<!-- <script src="./bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>