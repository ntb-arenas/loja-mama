<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  '../login/connect_DB.php';

$temporaryMsg = "";
$errorMessageMessage = "";
$message = "";

if (!isset($_SESSION["USER"])) {
  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
  header("Location: /login/login");
} else {
  // ler informações de conta 
  $username = $_SESSION["USER"];

  $stmt = $_conn->prepare('SELECT * FROM USERS WHERE USERNAME = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();

  $usersResult = $stmt->get_result();

  if ($usersResult->num_rows > 0) {
    while ($rowUsers = $usersResult->fetch_assoc()) {

      if (!isset($_POST["fName"], $_POST["lName"])) {
        $fName = $rowUsers['fNAME'];
        $lName = $rowUsers['lNAME'];
        $email = $rowUsers['EMAIL'];
        $telemovel = $rowUsers['TELEMOVEL'];
        $address = $rowUsers['MORADA'] . ", " . $rowUsers['COD_POSTAL'] . ", " . $rowUsers['CIDADE'];
        $reviewId = $rowUsers['ID'];
      } else {
        $podeRegistar = "Sim";
        $fName = mysqli_real_escape_string($_conn, $_POST['fName']);
        $fName = trim($fName);
        $lName = mysqli_real_escape_string($_conn, $_POST['lName']);
        $lName = trim($lName);
      }
    }
  } else {
    echo "STATUS ADMIN (Editar conta): " . mysqli_error($_conn);
  }
  mysqli_stmt_close($stmt);
}

if (isset($_POST['place-order'])) {
  $FourDigitRandomNumber = mt_rand(1111, 9999);
  $subTotal = $_POST['total'];

  foreach ($_SESSION['cart'] as $key => $value) {
    $result = mysqli_query($_conn, "SELECT * FROM OPTION_GROUP");
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        if ($row['CODE'] == $value['product_id1']) {
          $nameIdProduct1 = $row['NAME'];
          $priceProduct = $row['PRICE'];
          $typeProduct = $row['DESCRIPTION'];
        } else if ($row['CODE'] == $value['product_id2']) {
          $nameIdProduct2 = $row['NAME'];
          $priceProduct = $row['PRICE'];
          $typeProduct = $row['DESCRIPTION'];
        } else if ($row['CODE'] == $value['product_id']) {
          $nameIdProduct = $row['NAME'];
          $priceProduct = $row['PRICE'];
          $typeProduct = $row['DESCRIPTION'];
        }
      }
    }
    if (isset($value['product_id1']) && $value['product_id2']) {
      $valueProductId = $value['product_id1'] . $value['product_id2'];
      $nameIdProduct = $nameIdProduct1 . "+" . $nameIdProduct2;
    } else if (isset($value['product_id'])) {
      $valueProductId = $value['product_id'];
      $nameIdProduct = $nameIdProduct;
    }

    $invoiceId = "INV_" . $FourDigitRandomNumber;
    $sql = mysqli_query($_conn, "SELECT * FROM PRODUCTS");
    $sql = "INSERT INTO PRODUCTS (PRODUCT_ID, CODE, NAME, PRICE, TYPE) VALUES (?,?,?,?,?)";

    if ($stmt = mysqli_prepare($_conn, $sql)) {

      mysqli_stmt_bind_param($stmt, "sssis", $invoiceId, $valueProductId, $nameIdProduct, $totalPrice, $typeProduct);

      mysqli_stmt_execute($stmt);

      $temporaryMsg = "Sucesso!";

      // encaminhar com timer 3 segundos
      header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
      header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
      header("Refresh: 3; URL=checkout");
    } else {
      // echo "ERROR: Could not prepare query: $sql. " . mysqli_error($_conn);
      echo "STATUS ADMIN (alterar definições): " . mysqli_error($_conn);
    }
  }
  // Update user review ID
  $sql = mysqli_query($_conn, "SELECT * FROM ORDERS");
  $sql = "INSERT INTO ORDERS (INVOICE_ID, USER_ID, STATUS, PRICE, DATE) VALUES (?,?,?,?,?)";

  if ($stmt = mysqli_prepare($_conn, $sql)) {
    $status = 2;
    $data_hora = date("Y-m-d H:i:s", time());
    mysqli_stmt_bind_param($stmt, "ssids", $invoiceId, $username, $status, $subTotal, $data_hora);
    mysqli_stmt_execute($stmt);
  } else {
    echo "STATUS ADMIN: " . mysqli_error($_conn);
  }
  mysqli_stmt_close($stmt);
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
      <div class="row">
        <!-- Billing information -->
        <div class="col-12 col-xl-8">
          <div class="container-fluid border border-bottom-0">
            <p class="fs-5 m-0 py-3"><strong>Checkout</strong></p>
          </div>
          <div class="container-fluid border px-2">
            <form class="mt-4" action="#" method="POST">
              <!-- 2 column grid layout with text inputs for the first and last names -->
              <div class="row mb-4">
                <div class="col">
                  <div class="form-outline">
                    <input class="form-control" id="formControlReadonly" type="text" value="<?php echo $fName; ?>" disabled />
                    <label class="form-label" for="formControlReadonly">Nome</label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-outline">
                    <input class="form-control" id="formControlReadonly" type="text" value="<?php echo $lName; ?>" disabled />
                    <label class="form-label" for="formControlReadonly">Apelido</label>
                  </div>
                </div>
              </div>

              <!-- Text input -->
              <div class="form-outline mb-4">
                <input class="form-control" id="formControlReadonly" type="text" value="<?php echo $address; ?>" disabled />
                <label class="form-label" for="formControlReadonly">Morada de envio</label>
              </div>

              <!-- Email input -->
              <div class="form-outline mb-4">
                <input class="form-control" id="formControlReadonly" type="email" value="<?php echo $email; ?>" />
                <label class="form-label" for="formControlReadonly">E-mail</label>
              </div>

              <!-- Number input -->
              <div class="form-outline mb-4">
                <input class="form-control" id="formControlReadonly" type="text" value="<?php echo $telemovel; ?>" />
                <label class="form-label" for="formControlReadonly">Telemovel</label>
              </div>

              <!-- NIF -->
              <div class="form-outline mb-4">
                <input class="form-control" id="formControlReadonly" type="text" name="formNIF" />
                <label class="form-label" for="formControlReadonly">NIF</label>
              </div>

              <!-- Message input -->
              <div class="form-outline mb-4">
                <textarea class="form-control" id="form6Example7" rows="4"></textarea>
                <label class="form-label" for="form6Example7">Mensagem adicional</label>
              </div>
          </div>
        </div>
        <!-- Checkout cart -->
        <div class="col-12 col-xl-4 border p-0 mt-5 mt-xl-0">
          <div class="container-fluid px-2 border-bottom">
            <p class="fs-5 m-0 py-3"><strong>O seu carrinho</strong></p>
          </div>
          <div class="container-fluid p-0">
            <div class="container-fluid p-1 overflow-auto" style="height: 15rem">
              <?php
              $total = 0;
              if (!empty($_SESSION['cart'])) {
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
                        </div> <?php
                              }
                              if ($row['CODE'] == $value['product_id']) {
                                $_POST['nameIdProduct'] = $row['NAME'];
                                $_POST['priceProduct'] = $row['PRICE'];
                                $_POST['typeProduct'] = $row['DESCRIPTION']; ?>
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
                        </div><?php
                              }
                            }
                          }
                        }
                      } ?>
            </div>
            <div class="container-fluid pt-4 px-2">
              <div class="col-12 d-flex justify-content-between">
                <p class="m-0">Desconto</p>
                <p class="m-0">n/a</p>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <p class="m-0">Custo de envio</p>
                <p class="m-0 text-success">Envio gratis</p>
              </div>
              <div class="col-12 d-flex justify-content-between py-2">
                <p class="m-0" style="font-weight: 500;"><strong>Sub Total</strong></p>
                <p class="m-0" style="font-weight: 500;"><strong>
                    <?php
                    echo $total; ?>€</strong>
                </p>
              </div>
              <div class="container-fluid p-0 text-center">
                <button class="btn my-3" id="btn-customized" name="place-order" type="submit">CONFIRMAR</button>
              </div>
              </form>
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