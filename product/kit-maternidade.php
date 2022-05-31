<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  '../login/connect_DB.php';

if (isset($_POST['add'])) {
    if (isset($_SESSION['cart'])) {

        $item_array_id = array_column($_SESSION['cart'], "product_id");

        if (in_array($_POST['product_id'], $item_array_id)) {
            $temporaryMsg = '<div class="alert alert-warning mt-3 p-2" role="alert">Item already exists</div>';
        } else {

            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_POST['product_id'],
                'quantityInput' => $_POST['quantityInput']
            );

            $_SESSION['cart'][$count] = $item_array;
        }
    } else {

        $item_array = array(
            'product_id' => $_POST['product_id'],
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

</head>

<body>
    <?php include_once '../components/header.php'; ?>
    <?php include_once '../components/navbar.php'; ?>
    <main>


        <!--Product page starts here-->

        <div class="container mt-5 mb-custom">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div id="carouselKitM" class="carousel slide" data-mdb-ride="carousel">
                        <div class="carousel-indicators">
                            <?php
                            $num = 0;
                            $slideNum = 1;
                            $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPKM'");
                            while ($row = mysqli_fetch_array($result)) {
                                if ($row['CODE'] == 'KM1') {
                                    echo '
                                            <button type="button" data-mdb-target="#carouselKitM" data-mdb-slide-to="' . $num . '" class="active theme-background-color" aria-current="true" aria-label="Slide ' . $slideNum . '"></button>';
                                } else {
                                    $num = $num + 1;
                                    $slideNum = $slideNum + 1;
                                    echo '
                                            <button type="button" class="theme-background-color" data-mdb-target="#carouselKitM" data-mdb-slide-to="' . $num . '" aria-label="Slide ' . $slideNum . '"></button>';
                                }
                            }
                            ?>
                        </div>
                        <div class="carousel-inner">
                            <?php
                            $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPKM'");
                            while ($row = mysqli_fetch_array($result)) {
                                if ($row['CODE'] == 'KM1') {
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
                        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselKitM" data-mdb-slide="prev">
                            <span class="carousel-control-prev-icon theme-color" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-mdb-target="#carouselKitM" data-mdb-slide="next">
                            <span class="carousel-control-next-icon theme-color" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <form action='kit-maternidade' method='post'>
                        <h3 class="m-0" style="font-weight: 700;">Kit Maternidade</h3>
                        <hr class="mt-2">
                        <p style="font-size: 0.9rem;">O Kit maternidade é composto por: porta de documentos + bolsa para a primeira roupa do bebé.</p>
                        <p class="m-0"><small>Preço:</small><span class="fs-3" style="font-weight: 500;"> 18€</span></p>
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
                                    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP WHERE PACK = 'OPKM'");
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <option value='<?php echo $product_id = $row['CODE'] ?>'><?php echo $productname = $row['NAME'] ?></option>
                                        <?php $product_id = $row['CODE']; ?>
                                    <?php
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


        <!--Product page ends here-->


    </main>
    <?php include_once '../components/footer.php'; ?>
</body>
<script src="./js/script.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>