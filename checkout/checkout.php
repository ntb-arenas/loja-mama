<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  '../login/connect_DB.php';

// if (!isset($_SESSION['USER'])) {
//     header("Location: ./home");
//     exit;
// }

if (isset($_POST['remove'])) {
    if ($_GET['action'] == 'remove') {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value["product_id1"] == $_GET['id']) {
                unset($_SESSION['cart'][$key]);
                echo "<script>window.location = 'cart'</script>";
            }
            if ($value["product_id"] == $_GET['id']) {
                unset($_SESSION['cart'][$key]);
                echo "<script>window.location = 'cart'</script>";
            }
        }
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

        <nav class="mx-3 mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="../home">Início</a></li>
                <li class="breadcrumb-item active text-warning" aria-current="page">
                    <a class="text-decoration-none text-warning" href="./checkout">Checkout</a>
                </li>
            </ol>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="container-fluid border border-bottom-0">
                        <p class="fs-5 m-0 py-3"><strong>Billing information</strong></p>
                    </div>
                    <div class="container-fluid border">
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
                <div class="col-4">
                    <div class="container-fluid border">asd</div>
                </div>
            </div>
        </div>


        <?php include_once '../components/footer.php'; ?>
    </main>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>