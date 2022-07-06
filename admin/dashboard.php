<?php
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
  $username = $_SESSION["USER"];

  $stmt = $_conn->prepare('SELECT * FROM users WHERE USERNAME = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();

  $usersResult = $stmt->get_result();

  if ($usersResult->num_rows > 0) {
    while ($rowusers = $usersResult->fetch_assoc()) {
      $fName = $rowusers['fNAME'];
      $lName = $rowusers['lNAME'];
      $telemovel = $rowusers['TELEMOVEL'];
      $email = $rowusers['EMAIL'];
      $image_url = $rowusers['IMAGE_URL'];
    }
  } else {
    echo "STATUS ADMIN (Editar conta): " . mysqli_error($_conn);
  }
  mysqli_stmt_close($stmt);
}


// Total of today's orders
$totalResult = mysqli_query($_conn, "SELECT PRICE FROM orders WHERE DATE = CURDATE()");

$totalOrdersToday = 0;
if (mysqli_num_rows($totalResult) > 0) {
  while ($rowTotal = mysqli_fetch_assoc($totalResult)) {
    $totalOrdersToday = $totalOrdersToday + $rowTotal["PRICE"];
  }
}
mysqli_free_result($totalResult);

// Total of this month's orders
$totalResult = mysqli_query($_conn, "SELECT PRICE FROM orders WHERE DATE >= (LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND DATE < (LAST_DAY(NOW()) + INTERVAL 1 DAY);");

$totalOrdersThisMonth = 0;
if (mysqli_num_rows($totalResult) > 0) {
  while ($rowTotal = mysqli_fetch_assoc($totalResult)) {
    $totalOrdersThisMonth = $totalOrdersThisMonth + $rowTotal["PRICE"];
  }
}
mysqli_free_result($totalResult);

// Total orders
$totalResult = mysqli_query($_conn, "SELECT PRICE FROM orders");

$totalOrdersRecord = 0;
if (mysqli_num_rows($totalResult) > 0) {
  while ($rowTotal = mysqli_fetch_assoc($totalResult)) {
    $totalOrdersRecord = $totalOrdersRecord + $rowTotal["PRICE"];
  }
}
mysqli_free_result($totalResult);

// Total orders
$totalResult = mysqli_query($_conn, "SELECT COUNT(STATUS) AS TOTAL FROM orders");

$totalOrders = 0;
if (mysqli_num_rows($totalResult) > 0) {
  while ($rowTotal = mysqli_fetch_assoc($totalResult)) {
    $totalOrders = $rowTotal["TOTAL"];
  }
}
mysqli_free_result($totalResult);

// Pending orders
$totalResult = mysqli_query($_conn, "SELECT COUNT(STATUS) AS TOTAL FROM orders WHERE STATUS = 2");

$totalPending = 0;
if (mysqli_num_rows($totalResult) > 0) {
  while ($rowTotal = mysqli_fetch_assoc($totalResult)) {
    $totalPending = $rowTotal["TOTAL"];
  }
}
mysqli_free_result($totalResult);

// Orders in process
$totalResult = mysqli_query($_conn, "SELECT COUNT(STATUS) AS TOTAL FROM orders WHERE STATUS = 3");

$totalProcess = 0;
if (mysqli_num_rows($totalResult) > 0) {
  while ($rowTotal = mysqli_fetch_assoc($totalResult)) {
    $totalProcess = $rowTotal["TOTAL"];
  }
}
mysqli_free_result($totalResult);

// Orders delivered
$totalResult = mysqli_query($_conn, "SELECT COUNT(STATUS) AS TOTAL FROM orders WHERE STATUS = 1");

$totalDelivered = 0;
if (mysqli_num_rows($totalResult) > 0) {
  while ($rowTotal = mysqli_fetch_assoc($totalResult)) {
    $totalDelivered = $rowTotal["TOTAL"];
  }
}
mysqli_free_result($totalResult);

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
          <a href="dashboard" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color rounded-5" aria-current="true" style>
            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
          </a>
          <a href="user-management" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color rounded-5 mt-3" style>
            <i class="fas fa-users-cog fa-fw me-3"></i><span>Users</span>
          </a>
          <a href="dashboard" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color rounded-5 mt-3" style>
            <i class="fas fa-shopping-bag fa-fw me-3"></i><span>Products</span>
          </a>
          <a href="dashboard" class="list-group-item list-group-item-action py-2 ripple active theme-background-color theme-border-color rounded-5 mt-3" style>
            <i class="fas fa-shopping-basket fa-fw me-3"></i><span>Orders</span>
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

        <!-- Admin column -->
        <div class="col-12 col-md-4">
          <div class="container-fluid border p-3 h-100">
            <div class="container-fluid text-center">
              <img src="<?php echo $image_url; ?>" class="rounded-circle img-fluid" width="200" alt="">
            </div>
            <div class="container-fluid text-center pt-3 border-bottom">
              <h3 class="m-0"><?php echo $fName. ' '. $lName?></h3>
              <p>Admin</p>
            </div>
            <div class="container-fluid pt-3 px-0 px-xl-3">
              <p class="m-0" style="color: #acacac;">Correio eletrônico</p>
              <p><?php echo $email; ?></p>
              <p class="m-0" style="color: #acacac;">Telemóvel</p>
              <p>+351 <?php echo $telemovel; ?></p>
            </div>
            <div class="container-fluid px-0 px-lg-3">
              <p class="m-0" style="color: #acacac;">Social</p>
              <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998;" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
              <a class="btn btn-primary btn-floating m-1" style="background-color: #55acee;" href="#!" role="button"><i class="fab fa-twitter"></i></a>
              <a class="btn btn-primary btn-floating m-1 gradient-insta" href="#!" role="button"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </div>

        <!-- Dashboard -->
        <div class="col-12 col-md-8 mt-3 mt-md-0">
          <div class="container-fluid border p-3 h-100">
            <div class="row justify-content-around">

              <!-- Today's order -->
              <div class="col-12 col-sm-3 d-flex rounded-9 mb-4 py-3 justify-content-center flex-column text-center" style="background-color: #0694a2;">
                <i class="fas fa-layer-group fa-2x text-white my-2"></i>
                <p class="m-0 text-white" style="font-size: 1rem;">Encomendas Hoje</p>
                <p class="m-0 text-white" style="font-size: 2rem;">€<?php echo $totalOrdersToday; ?></p>
              </div>
              <!-- Today's order -->
              <div class="col-12 col-sm-3 d-flex rounded-9 mb-4 py-3 justify-content-center flex-column text-center" style="background-color: #3f83f8;">
                <i class="fas fa-layer-group fa-2x text-white my-2"></i>
                <p class="m-0 text-white" style="font-size: 1rem;">Este Mês</p>
                <p class="m-0 text-white" style="font-size: 2rem;">€<?php echo $totalOrdersThisMonth; ?></p>
              </div>
              <!-- Today's order -->
              <div class="col-12 col-sm-3 d-flex rounded-9 mb-4 py-3 justify-content-center flex-column text-center" style="background-color: #0e9f6e;">
                <i class="fas fa-layer-group fa-2x text-white my-2"></i>
                <p class="m-0 text-white" style="font-size: 1rem;">Encomendas Total</p>
                <p class="m-0 text-white" style="font-size: 2rem;">€<?php echo $totalOrdersRecord; ?></p>
              </div>
            </div>

            <div class="row justify-content-around">

              <!-- Total order -->
              <div class="col-12 col-sm-5 d-flex bg-dark rounded-9 mb-4 py-3">
                <div class="col-3 text-center my-auto">
                  <i class="fas fa-shopping-cart fa-2x" style="color: #ff5a1f;"></i>
                </div>
                <div class="container-fluid p-2">
                  <p class="m-0 font-gray" style="font-size: .875rem;">Total de encomendas</p>
                </div>
                <div class="container-fluid p-2">
                  <p class="m-0 text-white" style="font-size: 1.5rem;"><?php echo $totalOrders; ?></p>
                </div>
              </div>

              <!-- Pending orders -->
              <div class="col-12 col-sm-5 d-flex bg-dark rounded-9 mb-4 py-3">
                <div class="col-3 text-center my-auto">
                  <i class="fas fa-sync fa-2x" style="color: #3f83f8;"></i>
                </div>
                <div class="container-fluid p-2">
                  <p class="m-0 font-gray" style="font-size: .875rem;">Encomendas pendentes</p>
                </div>
                <div class="container-fluid p-2">
                  <p class="m-0 text-white" style="font-size: 1.5rem;"><?php echo $totalPending; ?></p>
                </div>
              </div>

              <!-- Order process -->
              <div class="col-12 col-sm-5 d-flex bg-dark rounded-9 mb-4 py-3">
                <div class="col-3 text-center my-auto">
                  <i class="fas fa-truck fa-2x" style="color: #0694a2;"></i>
                </div>
                <div class="container-fluid p-2">
                  <p class="m-0 font-gray" style="font-size: .875rem;">Encomendas em processo</p>
                </div>
                <div class="container-fluid p-2">
                  <p class="m-0 text-white" style="font-size: 1.5rem;"><?php echo $totalProcess; ?></p>
                </div>
              </div>

              <!-- Order delivered -->
              <div class="col-12 col-sm-5 d-flex bg-dark rounded-9 mb-4 py-3">
                <div class="col-3 text-center my-auto">
                  <i class="fas fa-check fa-2x" style="color: #0e9f6e;"></i>
                </div>
                <div class="container-fluid p-2">
                  <p class="m-0 font-gray" style="font-size: .875rem;">Encomendas entregues</p>
                </div>
                <div class="container-fluid p-2">
                  <p class="m-0 text-white" style="font-size: 1.5rem;"><?php echo $totalDelivered; ?></p>
                </div>
              </div>

            </div>

          </div>
        </div>

        <h5 class="mt-5">Encomendas Recentes</h5>
        <div class="col-12 table-responsive-md">
          <?php
          $result = mysqli_query($_conn, "SELECT users.MORADA, orders.EMAIL, orders.TELEMOVEL, orders.STATUS, orders.PRICE, orders.DATE FROM orders JOIN users ON orders.USER_ID = users.ID ORDER BY orders.DATE DESC;");
          ?>
          <table class="table rounded-5" style="background-color: #262626; border-color: gray;">
            <thead>
              <tr>
                <th class="text-white" scope="col">DATA ENCOMENDA</th>
                <th class="text-white" scope="col">MORADA ENTREGA</th>
                <th class="text-white" scope="col">TELEMOVEL</th>
                <th class="text-white" scope="col">MODO PAGAMENTO</th>
                <th class="text-white" scope="col">TOTAL ENCOMENDA</th>
                <th class="text-white" scope="col">STATUS</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                    <td class="text-white"><?php echo $data['DATE']; ?></th>
                    <td class="text-white"><?php echo $data['MORADA']; ?></td>
                    <td class="text-white"><?php echo $data['TELEMOVEL']; ?></td>
                    <td class="text-white">N/A</td>
                    <td class="text-white">€<?php echo $data['PRICE']; ?></td>
                    <td class="text-white">
                      <?php
                      if ($data['STATUS'] == 1) { ?>
                        <span class="rounded-5 px-2" style="background-color: #03543f;">Entregue</span>
                      <?php
                      } elseif ($data['STATUS'] == 2) { ?>
                        <span class="rounded-5 px-2" style="background-color: #1e429f;">Pending</span>
                      <?php
                      } elseif ($data['STATUS'] == 3) { ?>
                        <span class="rounded-5 px-2" style="background-color: #03543f;">Entregue</span>
                      <?php
                      } elseif ($data['STATUS'] == 4) { ?>
                        <span class="rounded-5 px-2" style="background-color: #9b1c1c;">Cancelado</span>
                      <?php
                      }
                      ?>
                    </td>
                  </tr>
                <?php
                }
              } else { ?>
                <tr>
                  <td class="text-white" colspan="8">No data found</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>


    </div>
  </main>
</body>
<!-- <script src="./bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>