<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  '../login/connect_DB.php';

if (isset($_POST['add'])) {
    if (isset($_SESSION['cart'])) {

        $item_array_id1 = array_column($_SESSION['cart'], "product_id1");
        $item_array_id2 = array_column($_SESSION['cart'], "product_id2");

        if (in_array($_POST['product_id1'], $item_array_id1) && in_array($_POST['product_id2'], $item_array_id2)) {
            $temporaryMsg = '<div class="alert alert-warning mt-3 p-2" role="alert">O produto já existe no carrinho!</div>';
        } else {

            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id1' => $_POST['product_id1'],
                'product_id2' => $_POST['product_id2'],
                'quantityInput' => $_POST['quantityInput']
            );

            $_SESSION['cart'][$count] = $item_array;
        }
    } else {

        $item_array = array(
            'product_id1' => $_POST['product_id1'],
            'product_id2' => $_POST['product_id2'],
            'quantityInput' => $_POST['quantityInput']
        );

        // Create new session variable
        $_SESSION['cart'][0] = $item_array;
    }
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
    <main>

        <?php include_once '../components/header.php'; ?>
        <?php include_once '../components/navbar.php'; ?>

        <!--Product page starts here-->

        <!-- Carousel wrapper -->
        <div class="container-lg mt-5 mb-custom">
            <div class="row">

                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-5 mb-sm-5 mb-custom">
                            <div id="carouselFrente" class="carousel slide" data-mdb-ride="carousel">
                                <div class="carousel-indicators">
                                    <?php
                                    $num = 0;
                                    $slideNum = 1;
                                    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPAP1'");
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['CODE'] == 'F1') {
                                            echo '
                                            <button type="button" data-mdb-target="#carouselFrente" data-mdb-slide-to="' . $num . '" class="active theme-background-color" aria-current="true" aria-label="Slide ' . $slideNum . '"></button>';
                                        } else {
                                            $num = $num + 1;
                                            $slideNum = $slideNum + 1;
                                            echo '
                                            <button type="button" class="theme-background-color" data-mdb-target="#carouselFrente" data-mdb-slide-to="' . $num . '" aria-label="Slide ' . $slideNum . '"></button>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="carousel-inner">
                                    <?php
                                    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPAP1'");
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['CODE'] == 'F1') {
                                            echo '
                                            <div class="carousel-item active">
                                                <img src="../' . $row["IMAGE_URL"] . '" class="d-block w-100" alt="Wild Landscape" />
                                            </div>
                                            ';
                                        } else {
                                            echo '
                                            <div class="carousel-item">
                                                <img src="../' . $row["IMAGE_URL"] . '" class="d-block w-100" alt="..." />
                                            </div>
                                            ';
                                        }
                                    }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-mdb-target="#carouselFrente" data-mdb-slide="prev">
                                    <span class="carousel-control-prev-icon theme-color" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-mdb-target="#carouselFrente" data-mdb-slide="next">
                                    <span class="carousel-control-next-icon theme-color" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-5 mb-sm-5">
                            <div id="carouselVerso" class="carousel slide" data-mdb-ride="carousel">
                                <div class="carousel-indicators">
                                    <?php
                                    $num = 0;
                                    $slideNum = 1;
                                    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPAP2'");
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['CODE'] == 'V1') {
                                            echo '
                                            <button type="button" data-mdb-target="#carouselFrente" data-mdb-slide-to="' . $num . '" class="active theme-background-color" aria-current="true" aria-label="Slide ' . $slideNum . '"></button>';
                                        } else {
                                            $num = $num + 1;
                                            $slideNum = $slideNum + 1;
                                            echo '
                                            <button type="button" class="theme-background-color" data-mdb-target="#carouselFrente" data-mdb-slide-to="' . $num . '" aria-label="Slide ' . $slideNum . '"></button>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="carousel-inner">
                                    <?php
                                    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPAP2'");
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['CODE'] == 'V1') {
                                            echo '
                                            <div class="carousel-item active">
                                                <img src="../' . $row["IMAGE_URL"] . '" class="d-block w-100" alt="Wild Landscape" />
                                            </div>
                                            ';
                                        } else {
                                            echo '
                                            <div class="carousel-item">
                                                <img src="../' . $row["IMAGE_URL"] . '" class="d-block w-100" alt="..." />
                                            </div>
                                            ';
                                        }
                                    }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-mdb-target="#carouselVerso" data-mdb-slide="prev">
                                    <span class="carousel-control-prev-icon theme-color" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-mdb-target="#carouselVerso" data-mdb-slide="next">
                                    <span class="carousel-control-next-icon theme-color" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-md-4">
                    <form action='almofadas-de-amamentacao' method='post'>
                        <h3 class="m-0" style="font-weight: 700;">Almofadas de Amamentação</h3>
                        <hr class="mt-2">
                        <p style="font-size: 0.9rem;">A Almofada de Amamentação MA-MA® pequena foi feita a pensar na mobilidade. As suas dimensões mais reduzidas (face à almofada original) permitem à mamã levá-la para todo o lado e amamentar em qualquer local com total conforto e comodidade.
                            <br><br>
                            As Almofada de Amamentação MA-MA® pequenas ajudam a mamã num conjunto de situações para que ela se possa focar no que é mais importante: o seu bebé. Foram concebidas especialmente para acompanhar a mamã para todo o lado, permitindo que a mamã adopte uma posição confortável a amamentar e que o bebé fique bem apoiado.
                        </p>
                        <p class="m-0"><small>Tamanho:</small><span class="fs-3" style="font-weight: 500;"> Pequena</span></p>
                        <p class="m-0"><small>Preço:</small><span class="fs-3" style="font-weight: 500;"> 35€</span></p>
                        <p class="m-0">
                            <small>
                                Qty:
                                <select name="quantityInput">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </small>
                        </p>

                        <div class="row">
                            <div class="col">
                                Frente
                                <select class="form-select" name='product_id1'>
                                    <?php
                                    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPAP1'");
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <option value='<?php echo $productid = $row['CODE'] ?>'><?php echo $productname = $row['NAME'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                Verso
                                <select class="form-select" name='product_id2'>
                                    <?php
                                    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPAP2'");
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <option value='<?php echo $productid = $row['CODE'] ?>'><?php echo $productname = $row['NAME'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button class="btn mt-3" id="btn-customized" name="add" type="submit">COMPRAR <i class='fas fa-shopping-cart'></i></button>
                    </form>
                    <?php
                    echo $temporaryMsg;
                    mysqli_free_result($result);
                    ?>
                </div>
            </div>
        </div>
        <!-- Carousel wrapper -->

        <!-- Acabamentos -->
        <div class="container mt-5">
            <h1 class="text-center m-0" style="font-weight: 500;">Acabamentos</h1>
        </div>
        <hr>
        <div class="container">
            <p><b>Todas as nossas almofadas têm acabamentos importantes para o bem-estar da mãe e do bebé:</b></p>
            <p><b>- Forro com fecho invisível</b>: Permite a lavagem sempre que necessário ou modificar o padrão do forro sempre que quiser.<br><b>- Fecho em velcro</b>: Estas almofadas fecham, fazendo um ninho que permite dar maior apoio e versatilidade à almofada.
            </p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3 mb-1"><img src="../gallery/almofadaPequena/1.jpg" class="img-fluid" alt=""></div>
                <div class="col-12 col-sm-3 mb-1"><img src="../gallery/almofadaPequena/2.jpg" class="img-fluid" alt=""></div>
            </div>
        </div>
        <!-- Acabamentos -->

        <!--Product page ends here-->


        <?php include_once '../components/footer.php'; ?>
    </main>
</body>
<script src="../js/script.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>