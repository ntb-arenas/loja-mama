<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
include_once  '../login/connect_DB.php';

if (isset($_POST['btn-cancel-changes'])) {
  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
  header("Location: ./profile-account");
}

if (isset($_POST['btn-forgot-pass'])) {

  session_destroy(); // destruição imediata de sessão

  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
  header("Location: ../recover-password");
}

$temporaryMsg = "";

$errorMessagefName = "";
$errorMessagelName = "";
$errorMessagePassword = "";
$errorMessageTelemovel = "";
$errorMessageCodPostal = "";

$telemovel = "";
$morada = "";
$codPostal = "";
$cidade = "";
$pais = "";

if (!isset($_SESSION["USER"])) {
  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
  header("Location: ../home");
} else {
  // ler informações de conta 
  $username = $_SESSION["USER"];

  $stmt = $_conn->prepare('SELECT * FROM users WHERE USERNAME = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();

  $usersResult = $stmt->get_result();

  if ($usersResult->num_rows > 0) {
    while ($rowusers = $usersResult->fetch_assoc()) {

      $password = "";
      $encryptedPassword = $rowusers['PASSWORD'];
      $morada = $rowusers['MORADA'];
      $telemovel = $rowusers['TELEMOVEL'];
      $cidade = $rowusers['CIDADE'];
      $codPostal = $rowusers['COD_POSTAL'];
      $pais = $rowusers['PAIS'];

      if (!isset($_POST["fName"], $_POST["lName"])) {
        $fName = $rowusers['fNAME'];
        $lName = $rowusers['lNAME'];
        $receberMsgs = $rowusers['MSGS_MARKETING'];
      } else {
        $podeRegistar = "Sim";
        $fName = mysqli_real_escape_string($_conn, $_POST['fName']);
        $fName = trim($fName);
        $lName = mysqli_real_escape_string($_conn, $_POST['lName']);
        $lName = trim($lName);
        $morada = mysqli_real_escape_string($_conn, $_POST['formMorada']);
        $morada = trim($morada);
        $cidade = mysqli_real_escape_string($_conn, $_POST['formCidade']);
        $cidade = trim($cidade);
        $telemovel = mysqli_real_escape_string($_conn, $_POST['formTelemovel']);
        $telemovel = trim($telemovel);
        $codPostal = mysqli_real_escape_string($_conn, $_POST['formCodPostal']);
        $codPostal = trim($codPostal);
        $pais = mysqli_real_escape_string($_conn, $_POST['formPais']);
        $pais = trim($pais);

        $receberMensagens = $_POST['receberMensagens'];
        if ($receberMensagens == "Sim") {
          $receberMsgs = 1;
        } else {
          $receberMsgs = 0;
        }

        if (strlen(trim($fName)) < 2) {
          $errorMessagefName = "O nome é demasiado curto!";
          $podeRegistar = "Nao";
        }

        if (strlen(trim($lName)) < 2) {
          $errorMessagelName = "O apelido é demasiado curto!";
          $podeRegistar = "Nao";
        }
        if (strlen(trim($telemovel)) < 9) {
          $errorMessageTelemovel = "O número telemóvel é invalido!";
          $podeRegistar = "Nao";
        }
        if (strlen(trim($codPostal)) < 8) {
          $errorMessageCodPostal = "O código postal fornecido parece ser inválido. 
                    Exemplo: 5360-316; 1234-567";
          $podeRegistar = "Nao";
        }
      }
    }
  } else {
    echo "STATUS ADMIN (Editar conta): " . mysqli_error($_conn);
  }
  mysqli_stmt_close($stmt);
}



if (isset($_POST['btn-save-changes'])) {

  // verificar senha por questões de segurança
  $password = mysqli_real_escape_string($_conn, $_POST['password']);
  $password = trim($password);


  if (password_verify($password, $encryptedPassword)) {

    // senha OK, filtar e validar inputs

  } else {
    $errorMessagePassword = "Senha incorreta!";
    $podeRegistar = "Nao";
  }


  if ($podeRegistar == "Sim") {

    ///////////////////////////////////
    // ALTERA/INSIRA
    //////////////////////////////////

    $morada = strip_tags($morada);
    $cidade = strip_tags($cidade);
    $telemovel = strip_tags($telemovel);
    $pais = strip_tags($pais);
    $fName = strip_tags($fName);
    $lName = strip_tags($lName);

    $sql = "UPDATE users SET fNAME = ?, lNAME = ?, MORADA = ?, COD_POSTAL = ?, CIDADE = ?, PAIS = ?, TELEMOVEL = ?, MSGS_MARKETING = ? WHERE USERNAME = ?";

    if ($stmt = mysqli_prepare($_conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssssssis", $fName, $lName, $morada, $codPostal, $cidade, $pais, $telemovel, $receberMsgs, $username);
      mysqli_stmt_execute($stmt);

      $temporaryMsg = "Definições de conta alteradas com sucesso.";

      // Update session variables
      $_SESSION["FIRSTNAME_USER"] = $fName;
      $_SESSION["LASTNAME_USER"] = $lName;

      // Redirect with 3 seconds timer
      header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
      header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
      header("Refresh: 3; URL=./edit-account");
    } else {
      // echo "ERROR: Could not prepare query: $sql. " . mysqli_error($_conn);
      echo "STATUS ADMIN (alterar definições): " . mysqli_error($_conn);
    }

    // Update user review ID
    $sql = mysqli_query($_conn, "SELECT * FROM users");
    $sql = "UPDATE users SET REVIEW_ID=? WHERE USERNAME=?";

    if ($stmt = mysqli_prepare($_conn, $sql)) {

      mysqli_stmt_bind_param($stmt, "ss", $userId, $username);
      mysqli_stmt_execute($stmt);
    } else {
      echo "STATUS ADMIN: " . mysqli_error($_conn);
    }

    mysqli_stmt_close($stmt);
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
  <?php include_once '../components/header.php'; ?>
  <?php include_once '../components/navbar.php'; ?>
  <main>
    <div class="container-md py-3">
      <h2>Olá <?php echo $_SESSION["FIRSTNAME_USER"] . " " . $_SESSION["LASTNAME_USER"] ?>, </h2>
      <h5><a href="/login/userSair.php">Logout</a></h5>
    </div>

    <div class="container-md mb-3">
      <div class="row">
        <!-- Responsive tech -->
        <div class="col-12 col-md-3">
          <div class="list-group list-group-light d-none d-md-block">
            <a href="./profile-account" class="list-group-item list-group-item-action px-3 border-0">INFORMAÇÕES DA CONTA</a>
            <a href="./encomendas" class="list-group-item list-group-item-action px-3 border-0">AS MINHAS ENCOMENDAS</a>
            <a href="./edit-account" class="list-group-item list-group-item-action px-3 border-0  active" id="account-style" aria-current="true">EDITAR CONTA</a>
            <a href="./favorite" class="list-group-item list-group-item-action px-3 border-0">LISTA DE DESEJOS</a>
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
                        <a href="./edit-account" class="list-group-item list-group-item-action px-3 border-0  active" id="account-style" aria-current="true">EDITAR CONTA</a>
                        <a href="./favorite" class="list-group-item list-group-item-action px-3 border-0">LISTA DE DESEJOS</a>
                        <a href="./reviews" class="list-group-item list-group-item-action px-3 border-0">TESTEMUNHO</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Responsive tech -->

        <div class="col-12 col-md-9 mt-3 border-start">
          <div class="container border p-3">
            <h2>Editar conta</h3>
              <?php
              if ($podeRegistar == 'Sim') { ?>
                <div class="alert alert-success mt-3" role="alert">
                  <?php echo $temporaryMsg; ?>
                </div>
              <?php
              }
              ?>
              <form action="#" method="POST">
                <div class="form-group">
                  <label for="form-login-input">Nome</label>
                  <input type="text" class="form-control" name="fName" value="<?php echo $fName; ?>" id="form-login-input">
                  <p><?php echo $errorMessagefName; ?></p>
                </div>
                <div class="form-group">
                  <label for="form-login-input">Apelido</label>
                  <input type="text" class="form-control" name="lName" value="<?php echo $lName; ?>" id="form-login-input">
                  <p><?php echo $errorMessagelName; ?></p>
                </div>
                <div class="form-group">
                  <label for="form-login-input">Número de telemóvel</label>
                  <input type="text" class="form-control" name="formTelemovel" value="<?php echo $telemovel; ?>" id="form-login-input">
                  <p><?php echo $errorMessageTelemovel; ?></p>
                </div>
                <div class="form-group">
                  <label for="form-login-input">Morada</label>
                  <input type="text" class="form-control" name="formMorada" value="<?php echo $morada; ?>" id="form-login-input">
                  <p></p>
                </div>
                <div class="form-group">
                  <label for="form-login-input">Código Postal</label>
                  <input type="text" class="form-control" name="formCodPostal" value="<?php echo $codPostal; ?>" id="form-login-input">
                  <p><?php echo $errorMessageCodPostal; ?></p>
                </div>
                <div class="form-group">
                  <label for="form-login-input">Cidade</label>
                  <input type="text" class="form-control" name="formCidade" value="<?php echo $cidade; ?>" id="form-login-input">
                  <p></p>
                </div>
                <div class="form-group">
                  <label for="form-login-input">País</label>
                  <input type="text" class="form-control" name="formPais" value="<?php echo $pais; ?>" id="form-login-input" disabled>
                  <p></p>
                </div>
                <div>Pretendo receber mensagens de marketing:</div>
                <select name="receberMensagens">
                  <option value="Sim" <?php if ($receberMsgs == 1) {
                                        echo " selected";
                                      } ?>>Sim</option>
                  <option value="Não" <?php if ($receberMsgs == 0) {
                                        echo " selected";
                                      } ?>>Não</option>
                </select>

                <div class="alert alert-warning mt-3" role="alert">
                  Por uma questão de segurança, para alterar as suas definições de conta deverá digitar a
                  sua senha. No final, não se esqueça de gravar as alterações. Se apenas pretende alterar a sua senha use a opção <a href="./recover-password"><strong>Esqueci-me da senha</strong></a>.
                </div>
                <div class="form-group">
                  <label for="password1-login-input">Senha</label>
                  <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" id="password1-login-input">
                  <p><?php echo $errorMessagePassword; ?></p>
                </div>
                <button class="btn" id="btn-customized" name="btn-save-changes" type="submit">GRAVAR</button>
                <button class="btn" id="btn-customized" name="btn-cancel-changes" type="submit">CANCELAR</button>
              </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include_once '../components/footer.php'; ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>