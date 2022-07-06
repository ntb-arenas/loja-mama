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

// Keep the search criteria
if (isset($_POST["filtroSQL"])) {

  $filtroSQL = $_POST["filtroSQL"];

  if (trim($filtroSQL) == '') {
    $filtroSQL = "SELECT ID, USERNAME, EMAIL, fNAME, lNAME, USER_LEVEL, USER_STATUS, MSGS_MARKETING, DATE_HOUR FROM users ORDER BY ID ASC";
  }
} else {
  $filtroSQL = "SELECT ID, USERNAME, EMAIL, fNAME, lNAME, USER_LEVEL, USER_STATUS, MSGS_MARKETING, DATE_HOUR FROM users ORDER BY ID ASC";
}

$campoPesquisa = "";
if (isset($_POST['search-users'])) {

  $campoPesquisa = trim(mysqli_real_escape_string($_conn, $_POST['campoPesquisa']));

  if (trim($campoPesquisa) != "") {

    $filtroSQL = "SELECT ID, USERNAME, EMAIL, fNAME, lNAME, USER_LEVEL, USER_STATUS, MSGS_MARKETING, DATE_HOUR FROM users  WHERE (ID LIKE '%$campoPesquisa%') OR (USERNAME LIKE '%$campoPesquisa%') OR (EMAIL LIKE '%$campoPesquisa%') ORDER BY ID ASC;";
  }
}


if (isset($_POST["edit-user"])) {
  $_SESSION["USER_ID"] = $_GET['id'];
  header("Location: user-management-edit");
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
      <h3 class="">User Management</h3>
      <i id="topAnchor"></i>
      <input id="filtroSQL" name="filtroSQL" type="hidden" value="<?php echo $filtroSQL; ?>">

      <form action="./user-management#topAnchor" method="POST">
        <div class="input-group p-3 rounded-5" style="background-color: #262626;">
          <input type="search" class="form-control rounded" placeholder="Pesquisar ID/Username/Email" name="campoPesquisa" value="<?php echo $campoPesquisa; ?>" aria-label="Search" aria-describedby="search-addon" />
          <button type="submit" name="search-users" class="btn" id="btn-customized">Pesquisar</button>
        </div>
      </form>

      <div class="table-responsive-lg mt-3">
        <?php
        $result = mysqli_query($_conn, $filtroSQL);
        ?>
        <table class="table rounded-5" style="background-color: #262626; border-color: gray;">
          <thead>
            <tr>
              <th class="text-white" scope="col">ID</th>
              <th class="text-white" scope="col">USERNAME</th>
              <th class="text-white" scope="col">NAME</th>
              <th class="text-white" scope="col">EMAIL</th>
              <th class="text-white" scope="col">STATUS</th>
              <th class="text-white" scope="col">DATE</th>
              <th class="text-white" scope="col">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
              while ($data = mysqli_fetch_assoc($result)) { ?>
                <tr>
                  <td class="text-white"><?php echo $data['ID']; ?></th>
                  <td class="text-white"><?php echo $data['USERNAME']; ?></td>
                  <td class="text-white"><?php echo $data['fNAME'] . ' ' . $data['lNAME']; ?></td>
                  <td class="text-white"><?php echo $data['EMAIL']; ?></td>
                  <td class="text-white">
                    <?php
                    if ($data['USER_LEVEL'] == 1) {
                      if ($data['USER_STATUS'] == 2) {
                        $blocked = '<span class="rounded-5 px-2" style="background-color: #9b1c1c;">Blocked</span>';
                        echo $blocked;
                      } elseif ($data['USER_STATUS'] == 1) {
                        $active = '<span class="rounded-5 px-2" style="background-color: #03543f;">Active</span>';
                        echo $active;
                      } elseif ($data['USER_STATUS'] == 0) {
                        $notVerified = '<span class="rounded-5 px-2" style="background-color: #ff7b46;">Not Verified</span>';
                        echo $notVerified;
                      }
                    } else if ($data['USER_LEVEL'] == 2) { ?>
                      <span class="rounded-5 px-2" style="background-color: #1e429f;">Admin</span>
                    <?php
                    } ?>
                  </td>
                  <td class="text-white"><?php echo $data['DATE_HOUR']; ?></td>
                  <td class="text-white text-center">
                    <form action="user-management?id=<?php echo $data['ID']; ?>" method="POST">
                      <button type="submit" name="edit-user" class="btn-custom-1">
                        <i class="far fa-edit text-white"></i>
                      </button>
                    </form>
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
  </main>
</body>
<!-- <script src="./bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>