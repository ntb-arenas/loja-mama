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

        <nav class="mx-3 mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="../home">Início</a></li>
                <li class="breadcrumb-item active text-warning" aria-current="page">
                    <a class="text-decoration-none text-warning" href="./checkout">Checkout</a>
                </li>
            </ol>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="container-fluid border border-bottom-0">
                        <p class="fs-5 m-0 py-3"><strong>Billing information</strong></p>
                    </div>
                    <div class="container-fluid border px-2">
                        <form class="mt-4">
                            <!-- 2 column grid layout with text inputs for the first and last names -->
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" id="form6Example1" class="form-control" />
                                        <label class="form-label" for="form6Example1">First name</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" id="form6Example2" class="form-control" />
                                        <label class="form-label" for="form6Example2">Last name</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Text input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="form6Example4" class="form-control" />
                                <label class="form-label" for="form6Example4">Address</label>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="form6Example5" class="form-control" />
                                <label class="form-label" for="form6Example5">Email</label>
                            </div>

                            <!-- Number input -->
                            <div class="form-outline mb-4">
                                <input type="number" id="form6Example6" class="form-control" />
                                <label class="form-label" for="form6Example6">Phone</label>
                            </div>

                            <!-- Message input -->
                            <div class="form-outline mb-4">
                                <textarea class="form-control" id="form6Example7" rows="4"></textarea>
                                <label class="form-label" for="form6Example7">Additional information</label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-xl-4 border p-0 mt-5 mt-xl-0">
                    <div class="container-fluid px-2 border-bottom">
                        <p class="fs-5 m-0 py-3"><strong>O seu carrinho</strong></p>
                    </div>
                    <div class="container-fluid p-0">
                        <div class="container-fluid p-1 overflow-auto" style="height: 15rem">
                            <?php
                            $total = 0;
                            if (!empty($_SESSION['cart'])) { ?>
                                <?php
                                foreach ($_SESSION['cart'] as $key => $value) {
                                    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP");
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            if ($row['CODE'] == $value['product_id1']) { ?>
                                                <div class='container-fluid mb-3 gx-0'>
                                                    <div class="row border-bottom gx-0">
                                                        <div class="col-4 text-center">
                                                            <img src=".<?php echo $row['IMAGE_URL'] ?>" alt='Image1' class='img-fluid'>
                                                            <h5 class='pt-2 checkout-description'>(Frente): <?php echo $row['NAME'] ?></h5>
                                                        </div>
                                                    <?php
                                                    $totalQuantity = (int)$row['PRICE'] * $value['quantityInput'];
                                                    $total = $total + $totalQuantity;
                                                }
                                                if ($row['CODE'] == $value['product_id2']) { ?>
                                                        <div class="col-4 text-center">
                                                            <img src=".<?php echo $row['IMAGE_URL'] ?>" alt='Image1' class='img-fluid'>
                                                            <h5 class='pt-2 checkout-description'>(Verso): <?php echo $row['NAME'] ?></h5>
                                                        </div>
                                                        <div class="col-1 text-center">
                                                        </div>
                                                        <div class="col-1 text-center">
                                                            <h5 class='pt-2'><?php echo $value['quantityInput'] ?></h5>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <h5 class='pt-2'>€<?php echo $totalQuantity ?></h5>
                                                        </div>
                                                    </div>
                                                </div> <?php }
                                                    if ($row['CODE'] == $value['product_id']) { ?>
                                                <div class="container-fluid mb-3 gx-0">
                                                    <?php
                                                        $totalQuantity = (int)$row['PRICE'] * $value['quantityInput'];
                                                        $total = $total + $totalQuantity;
                                                    ?>
                                                    <div class="row border-bottom gx-0">
                                                        <div class="col-2 text-center">
                                                            <img src=".<?php echo $row['IMAGE_URL'] ?>" alt='Image1' class='img-fluid'>
                                                        </div>
                                                        <div class="col-7">
                                                            <h5 class='pt-2 checkout-description'><?php echo $row['DESCRIPTION'] . '/' . $row['NAME'] ?></h5>
                                                        </div>
                                                        <div class="col-1 text-center">
                                                            <h5 class='pt-2'><?php echo $value['quantityInput'] ?></h5>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <h5 class='pt-2'>€<?php echo $totalQuantity ?></h5>
                                                        </div>
                                                    </div>
                                                </div> <?php
                                                    }
                                                }
                                            }
                                        }
                                    } ?>

                        </div>
                        <div class="container-fluid pt-4 px-2">
                            <div class="col-12 d-flex justify-content-between">
                                <p class="m-0">Sub Total</p>
                                <p class="m-0"><?php echo $total; ?>€</p>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <p class="m-0">Desconto</p>
                                <p class="m-0">n/a</p>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <p class="m-0">Custo de envio</p>
                                <p class="m-0 text-success">Envio gratis</p>
                            </div>
                            <div class="col-12 d-flex justify-content-between py-2">
                                <p class="m-0" style="font-weight: 600;">Total de encomenda</p>
                                <p class="m-0" style="font-weight: 600;"><?php echo $total; ?>€</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once '../components/footer.php'; ?>
    </main>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>