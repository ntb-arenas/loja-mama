<?php

session_start();
include_once  '../login/connect_DB.php';

if (!isset($_SESSION["USER"])) {
  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
  header("Location: /login/login");
} else {
  // ler informações de conta 
  $username = $_SESSION["USER"];

  $stmt = $_conn->prepare('SELECT * FROM users WHERE USERNAME = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();

  $usersResult = $stmt->get_result();

  if ($usersResult->num_rows > 0) {
    while ($rowusers = $usersResult->fetch_assoc()) {
      $morada = $rowusers['MORADA'];
      $telemovel = $rowusers['TELEMOVEL'];
      $cidade = $rowusers['CIDADE'];
      $codPostal = $rowusers['COD_POSTAL'];
      $pais = $rowusers['PAIS'];
    }
  } else {
    echo "STATUS ADMIN (Editar conta): " . mysqli_error($_conn);
  }
  mysqli_stmt_close($stmt);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

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
</head>

<body>
  <?php include_once '/components/header.php'; ?>
  <?php include_once '/components/navbar.php'; ?>
  <main>
    <div class="container py-3">
      <h2>Olá <?php echo $_SESSION["FIRSTNAME_USER"] . " " . $_SESSION["LASTNAME_USER"] ?>, </h2>
      <h5><a href="/login/userSair">Logout</a></h5>
    </div>

    <div class="container-md mb-3">
      <div class="row">
        <div class="col-12 col-md-3">
          <div class="list-group list-group-light d-none d-md-block">
            <a href="./profile-account" class="list-group-item list-group-item-action px-3 border-0">INFORMAÇÕES DA CONTA</a>
            <a href="./encomendas" class="list-group-item list-group-item-action px-3 border-0">AS MINHAS ENCOMENDAS</a>
            <a href="./edit-account" class="list-group-item list-group-item-action px-3 border-0">EDITAR CONTA</a>
            <a href="./favorite" class="list-group-item list-group-item-action px-3 border-0  active" id="account-style" aria-current="true">LISTA DE DESEJOS</a>
            <a href="./reviews" class="list-group-item list-group-item-action px-3 border-0">TESTEMUNHO</a>
          </div>
          <div class="container-fluid d-md-none p-0">
            <div class="accordion" id="menuPanel">
              <div class="accordion-item">
                <h2 class="accordion-header" id="menu">
                  <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <p class="fs-3 m-0" style="font-weight: 400; color: #000;">Menu</p>
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse no-border" aria-labelledby="menu" data-mdb-parent="#menuPanel">
                  <div class="accordion-body">
                    <div class="col-12 col-md-6">
                      <div class="list-group list-group-light">
                        <a href="./profile-account" class="list-group-item list-group-item-action px-3 border-0">INFORMAÇÕES DA CONTA</a>
                        <a href="./encomendas" class="list-group-item list-group-item-action px-3 border-0">AS MINHAS ENCOMENDAS</a>
                        <a href="./edit-account" class="list-group-item list-group-item-action px-3 border-0">EDITAR CONTA</a>
                        <a href="./favorite" class="list-group-item list-group-item-action px-3 border-0 active" id="account-style" aria-current="true">LISTA DE DESEJOS</a>
                        <a href="./reviews" class="list-group-item list-group-item-action px-3 border-0">TESTEMUNHO</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-9 mt-3 border-start">
          Wishlist
        </div>
      </div>
    </div>
  </main>
  <?php include_once '../components/footer.php'; ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>