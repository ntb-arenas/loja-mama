<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  '../login/connect_DB.php';

if (isset($_POST['add'])) {
    if (isset($_SESSION['cart'])) {

        $item_array_id = array_column($_SESSION['cart'], "product_id");

        if (in_array($_POST['product_id'], $item_array_id)) {
            $temporaryMsg = "<script>alert('O produto já existe no carrinho!');</script>";
        } else {

            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_POST['product_id'],
                'quantityInput' => $_POST['quantityInput'],
            );

            $_SESSION['cart'][$count] = $item_array;
        }
    } else {

        $item_array = array(
            'product_id' => $_POST['product_id'],
            'quantityInput' => $_POST['quantityInput'],
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

  <?php include_once '/components/header.php'; ?>
  <?php include_once '/components/navbar.php'; ?>
    <main>
        <!--Product page starts here-->

        <div class="container mt-5 mb-custom">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div id="carouselCunha" class="carousel slide" data-mdb-ride="carousel">
                        <div class="carousel-indicators">
                            <?php
                            $num = 0;
                            $slideNum = 1;
                            $result = mysqli_query($_conn, "SELECT * FROM products WHERE PACK = 'OPC'");
                            while ($row = mysqli_fetch_array($result)) {
                                if ($row['CODE'] == 'C1') {
                                    echo '
                                            <button type="button" data-mdb-target="#carouselCunha" data-mdb-slide-to="' . $num . '" class="active theme-background-color" aria-current="true" aria-label="Slide ' . $slideNum . '"></button>';
                                } else {
                                    $num = $num + 1;
                                    $slideNum = $slideNum + 1;
                                    echo '
                                            <button type="button" class="theme-background-color" data-mdb-target="#carouselCunha" data-mdb-slide-to="' . $num . '" aria-label="Slide ' . $slideNum . '"></button>';
                                }
                            }
                            ?>
                        </div>
                        <div class="carousel-inner">
                            <?php
                            $result = mysqli_query($_conn, "SELECT * FROM products WHERE PACK = 'OPC'");
                            while ($row = mysqli_fetch_array($result)) {
                                if ($row['CODE'] == 'C1') {
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
                        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselCunha" data-mdb-slide="prev">
                            <span class="carousel-control-prev-icon theme-color" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-mdb-target="#carouselCunha" data-mdb-slide="next">
                            <span class="carousel-control-next-icon theme-color" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <form action='cunhas' method='post'>
                        <h3 class="m-0" style="font-weight: 700;">Cunhas</h3>
                        <hr class="mt-2">
                        <p style="font-size: 0.9rem;">Durante a gravidez ocorrem alguns desconfortos que, com algumas soluções alternativas, poderão ser minorados. Nesse sentido a MA-MA® acaba de lançar um produto que poderá servir de grande apoio, devolvendo à futura mamã uma boa qualidade de vida.</p>
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
                        <div class="row align-items-center mt-3">
                            <div class="col">
                                <select class="form-select" name='product_id'>
                                    <?php
                                    $result = mysqli_query($_conn, "SELECT * FROM products WHERE PACK = 'OPC'");
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <option value='<?php echo $product_id = $row['CODE'] ?>'><?php echo $productname = $row['NAME'] ?></option>
                                        <?php $product_id = $row['CODE']; ?>
                                    <?php
                                        $description = $row['DESCRIPTION'];
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <button class="btn" id="btn-customized" name="add" type="submit">
                                    COMPRAR <i class='fas fa-shopping-cart'></i>
                                </button>
                            </div>
                        </div>
                        <?php
                        echo $temporaryMsg;
                        mysqli_free_result($result);
                        ?>
                    </form>
                </div>
            </div>
        </div>

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
                            <img src="../gallery/cunhaProduct/1.png" class="img-fluid" alt="">
                        </div>
                        <button class="accordion-button collapsed transparent-background-color no-border" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Posição deitada de barriga para cima</p>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse no-border" aria-labelledby="headingOne" data-mdb-parent="#accordion1">
                        <div class="accordion-body">
                            <div class="col-12 col-md-6">
                                <p class="fs-custom" style="font-weight: 400; color: #414042;">A nova Cunha Pré Parto MA-MA® foi concebida especialmente para que a mamã consiga adoptar a posição deitada de barriga para cima, favorecendo assim o seu repouso ou sono em detrimento do habitual desconforto que sente quando o faz sem qualquer apoio de uma cunha específica ou com uma almofada normal.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion modo-utilizacao-bg" id="accordion2">
                <div class="accordion-item transparent-background-color no-border">
                    <h2 class="accordion-header" id="headingOne">
                        <div class="col-12 col-md-6">
                            <img src="../gallery/cunhaProduct/2.png" class="img-fluid" alt="">
                        </div>
                        <button class="accordion-button collapsed transparent-background-color no-border" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Posição sentada</p>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse no-border" aria-labelledby="headingOne" data-mdb-parent="#accordion2">
                        <div class="accordion-body">
                            <div class="col-12 col-md-6">
                                <p class="fs-custom" style="font-weight: 400; color: #414042;">O diferentes ângulos da Cunha Pré Parto MA-MA® permitem que a grávida adopte outras posições além da posição deitada de barriga para cima. Poderá ser utilizada numa posição sentada de forma a apoiar melhor as costas enquanto está a ler na cama ou a ver televisão no sofá.</p>
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
                        <img src="../gallery/cunhaProduct/1.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Posição deitada de barriga para cima</p>
                        <p class="fs-custom" style="font-weight: 400; color: #414042;">A nova Cunha Pré Parto MA-MA® foi concebida especialmente para que a mamã consiga adoptar a posição deitada de barriga para cima, favorecendo assim o seu repouso ou sono em detrimento do habitual desconforto que sente quando o faz sem qualquer apoio de uma cunha específica ou com uma almofada normal.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid modo-utilizacao-bg d-none d-sm-block">
            <div class="container-lg">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 order-2 order-md-1">
                        <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Posição sentada</p>
                        <p class="fs-custom" style="font-weight: 400; color: #414042;">O diferentes ângulos da Cunha Pré Parto MA-MA® permitem que a grávida adopte outras posições além da posição deitada de barriga para cima. Poderá ser utilizada numa posição sentada de forma a apoiar melhor as costas enquanto está a ler na cama ou a ver televisão no sofá.</p>
                    </div>
                    <div class="col-12 col-md-6 order-1 order-md-2">
                        <img src="../gallery/cunhaProduct/2.png" class="img-fluid" alt="">
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
        <div class="container fs-custom">
            <p><b>Todas as nossas Cunhas têm acabamentos importantes para o bem-estar da mãe:</b></p>
            <p><b>- Forro com fecho</b>: Permite a lavagem sempre que necessário ou modificar o padrão do forro sempre que quiser.</b></p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3 mb-1"><img src="../gallery/cunhaProduct/1Acab.jpg" class="img-fluid" alt=""></div>
                <div class="col-12 col-sm-3 mb-1"><img src="../gallery/cunhaProduct/2Acab.jpg" class="img-fluid" alt=""></div>
            </div>
        </div>
        <!-- Acabamentos -->
        <!--Product page ends here-->
    </main>
    <?php include_once '../components/footer.php'; ?>
</body>
<script src="../js/script.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>