<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once  '../login/connect_DB.php';

if (!isset($_SESSION["USER"])) {
  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
  header("Location: /error-pages/403-proibido");
} elseif ($_SESSION['ADMIN'] == 1) {
  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
  header("Location: /error-pages/403-proibido");
} else {
  // ler informações de conta 
  $invoiceId = $_SESSION["INVOICE_ID"];
  $morada = $_SESSION["morada"];

  $stmt = $_conn->prepare('SELECT * FROM orders WHERE INVOICE_ID = ?');
  $stmt->bind_param('s', $invoiceId);
  $stmt->execute();

  $usersResult = $stmt->get_result();

  if ($usersResult->num_rows > 0) {
    while ($rowusers = $usersResult->fetch_assoc()) {
      $userId = $rowusers['USER_ID'];
      $email = $rowusers['EMAIL'];
      $nif = $rowusers['NIF'];
      $telemovel = $rowusers['TELEMOVEL'];
      $status = $rowusers['STATUS'];
      $price = $rowusers['PRICE'];
      $orderTime = $rowusers['TIME'];
      $orderDate = $rowusers['DATE'];
    }
  } else {
    echo "STATUS ADMIN (Editar conta): " . mysqli_error($_conn);
  }
  mysqli_stmt_close($stmt);
}

// GET IMAGE
$usernameImage = $_SESSION["USER"];
$result = mysqli_query($_conn, "SELECT IMAGE_URL FROM users WHERE (USERNAME LIKE '%$usernameImage%')");

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $image_url = $row["IMAGE_URL"];
  }
}
mysqli_free_result($result);



if (isset($_POST["apply-edit"])) {
  if ($_POST["invoiceStatusOptions"]  == 1) {
    $status = 1;
  } else if ($_POST["invoiceStatusOptions"]  == 2) {
    $status = 2;
  } else if ($_POST["invoiceStatusOptions"]  == 3) {
    $status = 3;
  } else if ($_POST["invoiceStatusOptions"]  == 4) {
    $status = 4;
  }


  $sql = "UPDATE orders SET STATUS = ? WHERE INVOICE_ID = '$invoiceId'";

  if ($stmt = mysqli_prepare($_conn, $sql)) {

    mysqli_stmt_bind_param($stmt, "i", $status);

    mysqli_stmt_execute($stmt);
    header("Location: invoice-management");
  } else {
    // echo "ERROR: Could not prepare query: $sql. " . mysqli_error($_conn);
    echo "STATUS ADMIN (alterar definições): " . mysqli_error($_conn);
  }
  mysqli_stmt_close($stmt);
  unset($_SESSION["INVOICE_ID"]);
  unset($_SESSION["morada"]);
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
  <link rel="stylesheet" href="/css/style.css">
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
          <a href="dashboard" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color rounded-5" style>
            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
          </a>
          <a href="user-management" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color rounded-5 mt-3" aria-current="true" style>
            <i class="fas fa-users-cog fa-fw me-3"></i><span>Users</span>
          </a>
          <a href="invoice-management" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color rounded-5 mt-3" style>
            <i class="fas fa-shopping-basket fa-fw me-3"></i><span>Orders</span>
          </a>
          <a href="product-management" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color rounded-5 mt-3" style>
            <i class="fas fa-shopping-bag fa-fw me-3"></i><span>Products</span>
          </a>
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
              <img src="<?php echo $image_url; ?>" class="rounded-circle" height="35" width="35" alt="" loading="lazy" />
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="/login/userSair">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
  </header>

  <main class="main-admin" style="margin-top: 58px">
    <div class="container p-3">
      <h3 class="">Invoice</h3>

      <div>
        <form action="#" method="POST">
          Status:
          <select name="invoiceStatusOptions" id="invoiceStatusOptions">
            <option value='
                  <?php
                  if ($status == 1) {
                    echo 1;
                  } elseif ($status == 2) {
                    echo 2;
                  } elseif ($status == 3) {
                    echo 3;
                  } elseif ($status == 4) {
                    echo 4;
                  }
                  ?>
                  '>
              <?php
              if ($status == 1) {
                echo '--Concluído--';
              } elseif ($status == 2) {
                echo '--Pending--';
              } elseif ($status == 3) {
                echo '--Processo--';
              } elseif ($status == 4) {
                echo '--Cancelado--';
              } ?>
            </option>
            <option value="1">Concluído</option>
            <option value="3">Processo</option>
            <option value="4">Cancelado</option>
          </select>
          <button class="btn py-1 px-3" name="apply-edit" id="btn-customized" type="submit">Apply</button>
        </form>
      </div>


      <div class="container-fluid rounded-5 mt-3" style="background-color: #262626;">
        <div class="row">
          <?php $result = mysqli_query($_conn, "SELECT users.MORADA, users.fNAME, users.lNAME, orders.EMAIL, orders.INVOICE_ID, orders.USER_ID, orders.NIF, orders.TELEMOVEL, orders.STATUS, orders.PRICE, orders.DATE FROM orders JOIN users ON orders.USER_ID = users.ID");
          while ($row = mysqli_fetch_array($result)) {
            if ($invoiceId == $row['INVOICE_ID']) {
              $fName = $row['fNAME'];
              $lName = $row['lNAME'];
              $morada = $row['MORADA'];
            }
          }
          mysqli_free_result($result);
          ?>
          <div class="container p-3">
            <div class="col-12 d-flex justify-content-between align-items-center border-bottom" style="border-color: #52596f!important;">
              <div class="flex-column d-flex ">
                <span class="text-white fs-5">INVOICE</span>
                <span class="text-white" style="font-size: .8rem;">STATUS:
                  <?php
                  if ($status == 1) { ?>
                    <span class="rounded-5 px-2" style="background-color: #03543f;">Concluído</span>
                  <?php
                  } elseif ($status == 2) { ?>
                    <span class="rounded-5 px-2" style="background-color: #9f580a;">Pending</span>
                  <?php
                  } elseif ($status == 3) { ?>
                    <span class="rounded-5 px-2" style="background-color: #1e429f;">Processo</span>
                  <?php
                  } elseif ($status == 4) { ?>
                    <span class="rounded-5 px-2" style="background-color: #9b1c1c;">Cancelado</span>
                  <?php
                  }
                  ?>
                </span>
              </div>
              <div class="flex-column d-flex mb-3" style="font-size: .8rem;">
                <div class=" text-end">
                  <img src="/gallery/logo.png" width="120" alt="">
                </div>
                <span class="text-white text-end">
                  Centro Pré Pós Parto, <br> Rua José da Costa Pedreira 12C, <br> 1750-130 Lisboa
                </span>
              </div>
            </div>
          </div>

          <div class="container p-3">
            <div class="col-12 d-flex justify-content-between">
              <div class="flex-column d-flex ">
                <span class="text-white" style="font-size: 1rem;">DATE</span>
                <span class="text-white" style="font-size: .8rem;"><?php echo $orderDate; ?></span>
              </div>
              <div class="flex-column d-flex ">
                <span class="text-white" style="font-size: 1rem;">INVOICE NO</span>
                <span class="text-white" style="font-size: .8rem;">#<?php echo $invoiceId; ?></span>
              </div>
              <div class="flex-column d-flex text-end">
                <span class="text-white" style="font-size: 1rem;">INVOICE TO</span>
                <span class="text-white" style="font-size: .8rem;"><?php echo $fName . ' ' . $lName; ?></span>
                <span class="text-white" style="font-size: .8rem;"><?php echo $morada; ?></span>
              </div>
            </div>
          </div>


          <div class="container p-3 mt-3 table-responsive-lg">
            <table class="table text-white">
              <thead>
                <tr>
                  <th class="text-center" scope="col">PROD. CODE</th>
                  <th class="text-center" scope="col">PROD. NAME</th>
                  <th class="text-center" scope="col">PROD. TYPE</th>
                  <th class="text-center" scope="col">QUANTITY</th>
                  <th class="text-center" scope="col">ITEM PRICE</th>
                  <th class="text-center" scope="col">AMOUNT</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $result = mysqli_query($_conn, "SELECT * FROM invoice_products WHERE PRODUCT_ID = '$invoiceId'");
                while ($row = mysqli_fetch_array($result)) { ?>
                  <tr>
                    <td class="text-center"><?php echo $row['CODE']; ?></td>
                    <td class="text-center"><?php echo $row['NAME']; ?></td>
                    <td class="text-center"><?php echo $row['TYPE']; ?></td>
                    <td class="text-center fw-bold"><?php echo $row['QUANTITY']; ?></td>
                    <td class="text-center fw-bold">€<?php echo $row['PRICE']; ?></td>
                    <td class="text-center text-success fw-bold">€
                      <?php
                      $total = $row['PRICE'] * $row['QUANTITY'];
                      echo $total;
                      ?>
                    </td>
                  </tr>
                <?php
                  $totalAmount = $totalAmount + $total;
                }
                mysqli_free_result($result);
                ?>
              </tbody>
            </table>
          </div>

          <div class="container p-3 ">
            <div class="col-12 d-flex justify-content-between rounded-5 p-3" style="background-color: #333333;">
              <div class="flex-column d-flex text-start">
                <span class="text-white" style="font-size: 1rem;">PAYMENT METHOD</span>
                <span class="text-white" style="font-size: .8rem;">N/A</span>
              </div>
              <div class="flex-column d-flex text-center">
                <span class="text-white" style="font-size: 1rem;">ENVIO</span>
                <span class="text-white" style="font-size: .8rem;">GRATIS</span>
              </div>
              <div class="flex-column d-flex text-center">
                <span class="text-white" style="font-size: 1rem;">DISCOUNT</span>
                <span class="text-white" style="font-size: .8rem;">N/A</span>
              </div>
              <div class="flex-column d-flex">
                <span class="text-white" style="font-size: 1rem;">TOTAL AMOUNT</span>
                <span class="text-success fw-bold text-center" style="font-size: 1.5rem;">€<?php echo $totalAmount; ?></span>
              </div>
            </div>
          </div>
          <?php
          echo $temporaryMsg;
          ?>

        </div>
      </div>
    </div>
  </main>
</body>
<!-- <script src="./bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>