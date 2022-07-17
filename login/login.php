<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

include_once  './connect_DB.php';

$errorMessageUsername = "";
$errorMessagePassword = "";

if (isset($_SESSION["USER"])) {
  header("Location: ../home");
  exit;
}

if (isset($_POST['button-login'])) {

  $username = strtolower(trim(mysqli_real_escape_string($_conn, $_POST["formUsername"])));
  $username = trim($username);

  $password = trim(mysqli_real_escape_string($_conn, $_POST["formPassword"]));
  $password = trim($password);

  $username = strip_tags($username);

  $stmt = $_conn->prepare('SELECT * FROM users WHERE USERNAME = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();

  $usersResult = $stmt->get_result();

  if ($usersResult->num_rows > 0) {
    while ($rowusers = $usersResult->fetch_assoc()) {

      if ($rowusers['USER_STATUS'] == 2) { // BLocked user

        $errorMessagePassword = "Não é possível entrar no sistema. Contacte os nossos serviços para obter ajuda.";
      } else  if ($rowusers['USER_STATUS'] == 0) { // User account created but not verified

        $errorMessagePassword =  $rowusers['fNAME'] . ", ainda não ativou a sua conta. A mensagem com o código inicial de ativação de conta foi enviada para a sua caixa de correio. Caso não a encontre na sua caixa de entrada, verifique também o seu correio não solicitado ou envie-nos um email para ativarmos a sua conta. Obrigado.";
      } else  if (password_verify($password, $rowusers["PASSWORD"])) {

        $_SESSION["USER"] = $rowusers["USERNAME"];
        $_SESSION["LEVEL_USER"] = $rowusers["USER_STATUS"];
        $_SESSION["FIRSTNAME_USER"] = $rowusers["fNAME"];
        $_SESSION["LASTNAME_USER"] = $rowusers["lNAME"];
        $_SESSION["EMAIL_USER"] = $rowusers["EMAIL"];

        if ($rowusers["USER_LEVEL"] == 1) { // User logged in successfully
          header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
          header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
          header("Location: /account/profile-account");
          if (isset($_SESSION["pageId"])) { // Verify if user is logged in from checkout, if yes, redirect to checkout page
            unset($_SESSION["pageId"]);
            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
            header("Location: /checkout/checkout");
          }
          $_SESSION['ADMIN'] = $rowusers["USER_LEVEL"];
        } else { // Verify if user is an admin
          header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
          header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
          header("Location: /admin/dashboard");
          $_SESSION['ADMIN'] = $rowusers["USER_LEVEL"];
        }
      } else {
        $errorMessagePassword = "password incorreta!";
      }
    }
  } else {
    $errorMessageUsername = "O código de utilizador não existe na nossa base de dados!";
  }
  $stmt->free_result();
  $stmt->close();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ma-Ma Entrar</title>
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
  </style>
</head>

<body>
  <?php include_once '../components/header.php'; ?>
  <?php include_once '../components/navbar.php'; ?>
  <main>

    <nav class="mx-3 mt-3" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="/home">Início</a></li>
        <li class="breadcrumb-item active text-warning" aria-current="page">
          <a class="text-decoration-none text-warning" href="login">Inicie sessão na sua conta</a>
        </li>
      </ol>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6 ">
          <h2>Entre na sua conta!</h3>
            <form action="#" method="POST">
              <div class="form-group">
                <label for="form-login-input">Código de Utilizador</label>
                <input type="text" class="form-control" name="formUsername" value="<?php echo $username; ?>" id="form-login-input">
                <p><?php echo $errorMessageUsername; ?></p>
              </div>
              <div class="form-group">
                <label for="password-login-input">Senha</label>
                <input type="password" class="form-control" name="formPassword" value="<?php echo $password; ?>" id="password-login-input">
                <p class="text-danger"><?php echo $errorMessagePassword; ?></p>
              </div>
              <div class="recuperarSenha mt-3">
                <a class="link-dark" style="color: gray!important;" href="./userRecuperarSenha.php">Esqueceu-se da palavra-passe?</a>
              </div>
              <button class="btn mt-3" id="btn-customized" name="button-login" type="submit">INICIAR SESSÃO <i class="fas fa-sign-in-alt"></i></button>
            </form>
        </div>
        <div class="col-12 col-md-6 mt-5" id="login-page-divider1">
          <h2 class="text-center pt-3" id="login-page-divider2">Criar Conta</h3>
            <div class="container-fluid text-center">
              <a href="create-account" class="btn" id="btn-customized" role="button">CRIAR CONTA <i class="far fa-plus-square"></i></a>
            </div>
        </div>
      </div>
    </div>

  </main>
  <?php include_once '../components/footer.php'; ?>
</body>
<!-- <script src="../bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>