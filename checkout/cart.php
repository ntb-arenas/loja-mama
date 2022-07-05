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
      $value1 = $value["product_id1"] . $value["product_id2"];
      $value2 = $value["product_id"];
      if ($value1 == $_GET['id']) {
        unset($_SESSION['cart'][$key]);
        echo "<script>window.location = 'cart'</script>";
      }
      if ($value2 == $_GET['id']) {
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

    <div class="container-fluid mt-3">
      <div class="row px-md-5">
        <div class="col-md-7">
          <div class="shopping-cart">
            <h3><strong>Carrinho de compras</strong></h3>
            <hr>
            <?php
            $total = 0;
            if (!empty($_SESSION['cart'])) { ?>
              <div class="container d-none d-lg-block">
                <div class="row">
                  <div class="col-3 text-center">
                    <h4><strong>Item</strong></h4>
                  </div>
                  <div class="col-3">

                  </div>
                  <div class="col-2 text-center">
                    <h4><strong>Qty</strong></h4>
                  </div>
                  <div class="col-2 text-center">
                    <h4><strong>Preço</strong></h4>
                  </div>
                </div>
              </div>

              <?php
              foreach ($_SESSION['cart'] as $key => $value) {
                $result = mysqli_query($_conn, "SELECT * FROM option_group");
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_array($result)) {
                    if ($row['CODE'] == $value['product_id1']) { ?>
                      <div class='container mb-3 gx-0'>
                        <div class="row gx-0">
                          <div class="col-3 text-center">
                            <form action='cart?action=remove&id=<?php echo $value['product_id1'] . $value['product_id2'] ?>' method='post' class='cart-items'>
                              <img src=".<?php echo $row['IMAGE_URL'] ?>" alt='Image1' class='img-fluid'>
                              <h5 class='pt-2 checkout-description'>(Frente): <?php echo $row['NAME'] ?></h5>
                          </div>
                        <?php
                        $totalQuantity = (int)$row['PRICE'] * $value['quantityInput'];
                        $total = $total + $totalQuantity;
                      }
                      if ($row['CODE'] == $value['product_id2']) { ?>
                          <div class="col-3 text-center">
                            <img src=".<?php echo $row['IMAGE_URL'] ?>" alt='Image1' class='img-fluid'>
                            <h5 class='pt-2 checkout-description'>(Verso): <?php echo $row['NAME'] ?></h5>
                          </div>
                          <div class="col-2 text-center">
                            <h5 class='pt-2'><?php echo $value['quantityInput'] ?></h5>
                          </div>
                          <div class="col-2 text-center">
                            <h5 class='pt-2'>€<?php echo $totalQuantity ?></h5>
                          </div>
                          <div class="col-2 d-none d-sm-block">
                            <button type='submit' class='btn btn-danger m-2' name='remove'>Remover</button>
                          </div>
                          <div class="col-2 d-sm-none text-center">
                            <button type='submit' class='btn btn-danger p-0 fs-5' name='remove'>×</button>
                          </div>
                          </form>
                        </div>
                      </div> <?php
                            }

                            if ($row['CODE'] == $value['product_id']) { ?>
                      <div class="container mb-3 gx-0">
                        <form action='cart?action=remove&id=<?php echo $value['product_id'] ?>' method='post' class='cart-items'>
                          <?php
                              $totalQuantity = (int)$row['PRICE'] * $value['quantityInput'];
                              $total = $total + $totalQuantity;
                          ?>
                          <div class="row gx-0">
                            <div class="col-3 text-center">
                              <img src=".<?php echo $row['IMAGE_URL'] ?>" alt='Image1' class='img-fluid'>
                              <h5 class='pt-2 checkout-description'><?php echo $row['DESCRIPTION'] . '/' . $row['NAME'] ?></h5>
                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-2 text-center">
                              <h5 class='pt-2'><?php echo $value['quantityInput'] ?></h5>
                            </div>
                            <div class="col-2 text-center">
                              <h5 class='pt-2'>€<?php echo $totalQuantity ?></h5>
                            </div>
                            <div class="col-2 d-none d-sm-block">
                              <button type='submit' class='btn btn-danger m-2' name='remove'>Remover</button>
                            </div>
                            <div class="col-2 d-sm-none text-center">
                              <button type='submit' class='btn btn-danger p-0 fs-5' name='remove'>×</button>
                            </div>
                          </div>

                        </form>
                      </div> <?php
                            }
                          }
                        }
                      }
                    } else {
                      echo "<h6><strong>Carrinho está vazío!</strong></h6>";
                    } ?>
          </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
          <h5 class="mt-3"><strong>Resumo</strong></h5>
          <hr class="mt-1">
          <div class="row my-3">

            <div class="col-7">
              <h6>Custo de envio</h6>
            </div>
            <div class="col-5">
              <h6 class="text-success">Envio gratis</h6>
            </div>

            <div class="col-7">
              <h6>IVA</h6>
            </div>
            <div class="col-5">
              <h6>
                <?php
                $totalIva = ($total * 23) / 100;
                echo $totalIva; ?>€
              </h6>
            </div>

            <div class="col-7">
              <h6>Subtotal excl. IVA</h6>
            </div>
            <div class="col-5">
              <h6>
                <?php
                $totalNoIva = $total - $totalIva;
                echo $totalNoIva;
                ?>€
              </h6>
            </div>

            <div class="container">
              <hr>
            </div>
            <div class="col-7">
              <h6><strong>Subtotal</strong></h6>
            </div>
            <div class="col-5">
              <h6><strong><?php echo $total; ?>€</strong></h6>
            </div>
            <div class="col-12 mt-3 text-center">
              <a href="checkout">
                <button class="btn" id="btn-customized" type="submit">FINALIZAR</button>
                <?php $_SESSION["pageId"] = 1 ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include_once '../components/footer.php'; ?>
  </main>
</body>
<!-- <script src="./bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>