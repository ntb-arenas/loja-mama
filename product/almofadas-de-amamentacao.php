<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  '../login/connect_DB.php';

if (isset($_POST['add'])) {
    if (isset($_SESSION['cart'])) {

        $item_array_id1 = array_column($_SESSION['cart'], "product_id1");
        $item_array_id2 = array_column($_SESSION['cart'], "product_id2");

        if (in_array($_POST['product_id1'], $item_array_id1) && in_array($_POST['product_id2'], $item_array_id2)) {
            $temporaryMsg = "<script>alert('O produto já existe no carrinho!');</script>";
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
                                    $result = mysqli_query($_conn, "SELECT * FROM option_group WHERE PACK = 'OP1'");
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
                                    $result = mysqli_query($_conn, "SELECT * FROM option_group WHERE PACK = 'OP1'");
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
                                    $result = mysqli_query($_conn, "SELECT * FROM option_group WHERE PACK = 'OP2'");
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
                                    $result = mysqli_query($_conn, "SELECT * FROM option_group WHERE PACK = 'OP2'");
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
                        <p style="font-size: 0.9rem;">A Almofada de Amamentação MA-MA® Original serve como um apoio fundamental para a futura mamã, proporcionando noites de sono tranquilas e sem os habituais desconfortos que costumam ocorrer durante a gravidez. Chegada a altura de amamentar a almofada MA-MA® será igualmente uma fiel aliada, permitindo que a mamã adopte uma posição confortável e que o bebé fique bem apoiado.</p>
                        <p class="m-0"><small>Tamanho:</small><span class="fs-3" style="font-weight: 500;"> Grande</span></p>
                        <p class="m-0"><small>Preço:</small><span class="fs-3" style="font-weight: 500;"> 45€</span></p>
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
                                    $result = mysqli_query($_conn, "SELECT * FROM option_group WHERE PACK = 'OP1'");
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
                                    $result = mysqli_query($_conn, "SELECT * FROM option_group WHERE PACK = 'OP2'");
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

        <div class="container mt-5">
            <h1 class="text-center m-0" style="font-weight: 500;">Modo de Utilização</h1>
        </div>
        <hr>

        <!-- Mobile device -->
        <div class="container-fluid d-sm-none p-0">
            <div class="accordion modo-utilizacao-bg" id="accordion1">
                <div class="accordion-item transparent-background-color no-border">
                    <h2 class="accordion-header" id="headingOne">
                        <div class="col-12 col-md-6">
                            <img src="../gallery/productimg/amamentar.png" class="img-fluid" alt="">
                        </div>
                        <button class="accordion-button collapsed transparent-background-color no-border" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Para Amamentar</p>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse no-border" aria-labelledby="headingOne" data-mdb-parent="#accordion1">
                        <div class="accordion-body">
                            <div class="col-12 col-md-6">
                                <p class="fs-custom" style="font-weight: 400; color: #414042;">A Almofada de Amamentação MA-MA®️ ajuda a mãe a amamentar numa posição confortável, apoiando o bebé e evitando a colocação de stress desnecessário na coluna e costas da mãe. O fecho nas extremidades da almofada permitem que fique presa e apoiada, pelo que a mãe poderá focar-se totalmente no bebé e aproveitar o momento de vínculo.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion modo-utilizacao-bg" id="accordion2">
                <div class="accordion-item transparent-background-color no-border">
                    <h2 class="accordion-header" id="headingOne">
                        <div class="col-12 col-md-6">
                            <img src="../gallery/productimg/dormir.png" class="img-fluid" alt="">
                        </div>
                        <button class="accordion-button collapsed transparent-background-color no-border" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Para Dormir</p>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse no-border" aria-labelledby="headingOne" data-mdb-parent="#accordion2">
                        <div class="accordion-body">
                            <div class="col-12 col-md-6">
                                <p class="fs-custom" style="font-weight: 400; color: #414042;">A Almofada de Amamentação MA-MA é a aliada perfeita da mãe mesmo antes do nascimento do bebé. Com o seu tamanho e a sua forma em U, esta almofada ajuda a mãe a encontrar uma posição de repouso confortável tanto para ela como para o seu bebé.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion modo-utilizacao-bg" id="accordion3">
                <div class="accordion-item transparent-background-color no-border">
                    <h2 class="accordion-header" id="headingOne">
                        <div class="col-12 col-md-6">
                            <img src="../gallery/productimg/bebeDescansar.png" class="img-fluid" alt="">
                        </div>
                        <button class="accordion-button collapsed transparent-background-color no-border" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Para o bebé descansar</p>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse no-border" aria-labelledby="headingOne" data-mdb-parent="#accordion3">
                        <div class="accordion-body">
                            <div class="col-12 col-md-6">
                                <p class="fs-custom" style="font-weight: 400; color: #414042;">A Almofada de Amamentação MA-MA®️ permite que os bebés façam sestas em perfeita segurança sem o risco de se virarem. Além disso, também servem de redutor em cama de grades ou de ninho, aconchegando o bebé. Quando o bebé se começa a sentar, apoia-o, evitando desequilíbrios para os lados ou para trás.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile device -->

        <!-- large screens -->
        <div class="container-fluid modo-utilizacao-bg d-none d-sm-block">
            <div class="container-lg">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <img src="../gallery/productimg/amamentar.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Para Amamentar</p>
                        <p class="fs-custom" style="font-weight: 400; color: #414042;">A Almofada de Amamentação MA-MA®️ ajuda a mãe a amamentar numa posição confortável, apoiando o bebé e evitando a colocação de stress desnecessário na coluna e costas da mãe. O fecho nas extremidades da almofada permitem que fique presa e apoiada, pelo que a mãe poderá focar-se totalmente no bebé e aproveitar o momento de vínculo.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid modo-utilizacao-bg d-none d-sm-block">
            <div class="container-lg">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 order-2 order-md-1">
                        <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Para Dormir</p>
                        <p class="fs-custom" style="font-weight: 400; color: #414042;">A Almofada de Amamentação MA-MA é a aliada perfeita da mãe mesmo antes do nascimento do bebé. Com o seu tamanho e a sua forma em U, esta almofada ajuda a mãe a encontrar uma posição de repouso confortável tanto para ela como para o seu bebé.</p>
                    </div>
                    <div class="col-12 col-md-6 order-1 order-md-2">
                        <img src="../gallery/productimg/dormir.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid modo-utilizacao-bg d-none d-sm-block">
            <div class="container-lg">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 d-flex justify-content-center">
                        <img src="../gallery/productimg/bebeDescansar.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Para o bebé descansar</p>
                        <p class="fs-custom" style="font-weight: 400; color: #414042;">A Almofada de Amamentação MA-MA®️ permite que os bebés façam sestas em perfeita segurança sem o risco de se virarem. Além disso, também servem de redutor em cama de grades ou de ninho, aconchegando o bebé. Quando o bebé se começa a sentar, apoia-o, evitando desequilíbrios para os lados ou para trás.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- large screens -->

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
                <div class="col-12 col-sm-3 mb-1"><img src="../gallery/productimg/1.jpg" class="img-fluid" alt=""></div>
                <div class="col-12 col-sm-3 mb-1"><img src="../gallery/productimg/2.jpg" class="img-fluid" alt=""></div>
                <div class="col-12 col-sm-3 mb-1"><img src="../gallery/productimg/3.jpg" class="img-fluid" alt=""></div>
                <div class="col-12 col-sm-3 mb-1"><img src="../gallery/productimg/4.jpg" class="img-fluid" alt=""></div>
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