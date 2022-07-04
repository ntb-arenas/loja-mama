<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

include_once  './connect_DB.php';
include_once './function_mail_utf8.php';


// iniciar e limpar possíveis mensagens de erro
$temporaryMsg = "";

$errorMessageUsername = "";
$errorMessageEmail = "";
$errorMessagePassword = "";
$errorMessagePasswordRecover = "";
$errorMessagefName = "";
$errorMessagelName = "";

// inciar e limpar variáveis
$username = "";
$email = "";
$password = "";
$passwordConfirmation = "";
$fName = "";
$lName = "";
$aceito = "";
$aceitoMarketing = 0;

$geraFormulario = "Sim";

if (isset($_POST['button-cancel-account'])) {

  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
  header("Location: ../home");
}


if (isset($_POST['submit-create-account'])) {


  $podeCriarRegisto = "Sim";

  // obter parametros (determinadas validações poderiam ser feitas no lado cliente)
  $username = mysqli_real_escape_string($_conn, $_POST['formUser']);
  $username = strtolower(trim($username));
  $email = mysqli_real_escape_string($_conn, $_POST['formEmail']);
  $email = strtolower(trim($email));
  $password = mysqli_real_escape_string($_conn, $_POST['formPassword1']);
  $password = trim($password);
  $passwordConfirmation = mysqli_real_escape_string($_conn, $_POST['formPassword2']);
  $passwordConfirmation = trim($passwordConfirmation);
  $fName = mysqli_real_escape_string($_conn, $_POST['formfName']);
  $fName = trim($fName);
  $lName = mysqli_real_escape_string($_conn, $_POST['formlName']);
  $lName = trim($lName);
  $aceito = $_POST['formAceito'];

  if ($aceito == "aceito_marketing") {
    $aceitoMarketing = 1;
  } else {
    $aceitoMarketing = 0;
  }

  // retirar possíveis tags html do código
  $username = strip_tags($username);
  $email = strip_tags($email);
  $fName = strip_tags($fName);
  $lName = strip_tags($lName);
  $fName = ucfirst($fName);
  $lName = ucfirst($lName);

  // não permitir que um user tenha espaços no código...
  $username = str_replace(' ', '', $username);

  // validar parametros recebidos

  if (strlen(trim($username)) < 4) {
    $errorMessageUsername = "O código de utilizador é demasiado curto!";
    $podeCriarRegisto = "Nao";
  }

  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMessageEmail = "O e-mail não é válido!";
    $podeCriarRegisto = "Nao";
  }


  if (strlen(trim($password)) < 8) {
    $errorMessagePassword = "A senha tem que ter pelo menos 8 caracteres!";
    $podeCriarRegisto = "Nao";
  }

  if ($password != $passwordConfirmation) {
    $errorMessagePasswordRecover = "A senha de confirmação deve ser igual à primeira password!";
    $podeCriarRegisto = "Nao";
  }


  if (strlen(trim($fName)) < 2) {
    $errorMessagefName = "O primeiro nome é demasiado curto!";
    $podeCriarRegisto = "Nao";
  }

  if (strlen(trim($lName)) < 2) {
    $errorMessagelName = "O ultimo nome é demasiado curto!";
    $podeCriarRegisto = "Nao";
  }

  // a check box não precisa de ser validada..

  // inicio

  if ($podeCriarRegisto == "Sim") {

    // validações corretas: validar se existe utilizador
    $stmt = $_conn->prepare('SELECT * FROM users WHERE USERNAME = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $usersResult = $stmt->get_result();

    if ($usersResult->num_rows > 0) {

      $errorMessageUsername = "Já existe um utilizador registado com este código.";

      $stmt->free_result();
      $stmt->close();
    } else {

      ///////////////////////////////////
      // INSERE UTILIZADOR NA BASE DE DADOS
      //////////
      $sql = "INSERT INTO users (USERNAME, EMAIL, PASSWORD, fNAME, lNAME, PAIS, USER_LEVEL, USER_STATUS, MSGS_MARKETING, DATE_HOUR) VALUES (?,?,?,?,?,?,?,?,?,?)";

      if ($stmt = mysqli_prepare($_conn, $sql)) {

        $nivel = 1;
        $status = 0;

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        date_default_timezone_set('Europe/Lisbon');
        $data_hora = date("Y-m-d H:i:s", time());
        $pais = "Portugal";

        mysqli_stmt_bind_param($stmt, "ssssssiiis", $username, $email, $passwordHash, $fName, $lName, $pais, $nivel, $status, $aceitoMarketing, $data_hora);
        mysqli_stmt_execute($stmt);

        $geraFormulario = "Nao";
      } else {

        echo "STATUS ADMIN (inserir user): " . mysqli_error($_conn);
      }

      mysqli_stmt_close($stmt);
      //////////
      // INSERIDO
      ////////////////////////////////////////

      ////////////////////////////////////////////////////////////////////////////
      // registo efetuado, gerar token, preparar e enviar mail de ativação
      $code = md5(uniqid(rand()));

      $sql = "UPDATE users SET TOKEN_CODE=? WHERE USERNAME=?";

      if ($stmt = mysqli_prepare($_conn, $sql)) {

        mysqli_stmt_bind_param($stmt, "ss", $code, $username);
        mysqli_stmt_execute($stmt);

        // Update efetuado com sucesso, preparar e enviar mensagem 
        $id = base64_encode($username);

        $urlPagina = "ma-ma.ml";

        $mensagem  = "<table width=100% border=0><tr>";
        $mensagem .= '<td class="flex-out">
                                <div style="display: block; text-align: center; margin: 0 auto">
                                <a
                                href="https://ma-ma.ml/index"
                                style="display: block; border: none"
                                ><img src="https://i.ibb.co/8751HZh/AMMHeader.png" alt="Ma-Ma Header" border="0"></a>
                            </div>
                            </td>';
        $mensagem .= '<tr><td colspan=2><div
                            style="
                            font-family: Arial, Helvetica, sans-serif;
                            color: #393838;
                            font-size: 12pt;
                                line-height: 18pt;
                                text-align: center;
                                margin-top: 20px;
                                "
                                >
                                <center>
                                <span style="color: #ec6408; font-size: 18.5pt"
                                    ><strong>Obrigado por se ter registado! </strong></span
                                >
                                </center>
                                </div>
                                </td>
                                </tr>';
        $mensagem .= '
                                <tr><td colspan=2><br/><div
                                style="
                                font-family: Arial, Helvetica, sans-serif;
                                color: #393838;
                                line-height: 14pt;
                                text-align: center;
                                margin-top: 10px;
                                "
                                >
                                <center>
                                <span style="font-size: 14.5pt"
                                    ><strong
                                    >Para ativar a sua conta ' . $email . ' basta
                                    <br>
                                    carregar na seguinte
                                    ligação:
                                    </strong></span
                                >
                                </center>
                                <div style="display: block">
                                <img
                                    src="https://preview.wundermanlab.com/amm/20210706/spcr_13.png"
                                    alt=""
                                    class="spacer"
                                />
                                </div>
                                <a  class="btn" id="btn-customized" style="font-size: 12pt; margin-top: 10px;" role="button" href="' . $urlPagina . '/login/userVerifyAccount.php?id=' . $id . '&code=' . $code . '"><img src="https://i.ibb.co/f09G72M/cta.png" alt="Clique aqui para ativar" border="0"></a>
                                <div style="display: block">
                                <img
                                    src="https://preview.wundermanlab.com/amm/20210706/spcr_13.png"
                                    alt=""
                                    class="spacer"
                                />
                                </div>
                                </div></td></tr>';

        $mensagem .= '<tr><td colspan=2><div
                                style="
                                font-family: Arial, Helvetica, sans-serif;
                                color: #333;
                                font-size: 8pt;
                                line-height: 10pt;
                                text-align: center;
                                font-weight: bold;
                                margin-top: 5rem;
                                "
                                >
                                Centro Pré e Pós Parto - Rua José da Costa Pedreira No12, 1750-130
                                Lisboa
                                <div style="display: block">
                                <img
                                    src="https://preview.wundermanlab.com/amm/20210706/spcr_13.png"
                                    alt=""
                                    class="spacer"
                                />
                                </div>
                                </td
                                ></tr>';
        $mensagem .= '<td class="flex-out">
                                <div style="display: block; text-align: center; margin: 0 auto">
                                <a
                                    style="display: block; border: none"
                                    ><img
                                    src="https://i.ibb.co/KWMLns0/footer.jpg"
                                    alt="Ma-Ma footer"
                                    class="spacer logoFooter"
                                /></a>
                                </div>
                                </td></table>';


        $subject = "Ativação da sua conta em $urlPagina";

        // send email
        mail_utf8($email, $subject, $mensagem);
        //echo $mensagem; // apenas para efeitos de teste...
        //$temporar$temporaryMsg = $email . " " . $subject . " " . $mensagem;
        $temporaryMsg = $temporaryMsg . " " . "$fName, verifique por favor a sua caixa de correio para ativar de imediato a sua conta! Por vezes estas mensagens são consideradas correio não solicitado. Se não vir a mensagem de ativação verifique o seu correio não solicitado (SPAM).";
      } else {
        echo "STATUS ADMIN (gerar token): " . mysqli_error($_conn);
      }

      mysqli_stmt_close($stmt);
    }
  }


  // fim

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ma-Ma Criar Conta</title>
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

    <nav class="mx-3 mt-3" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="../home">Início</a></li>
        <li class="breadcrumb-item active text-warning" aria-current="page">
          <a class="text-decoration-none text-warning" href="./login">Inicie sessão na sua conta</a>
        </li>
      </ol>
    </nav>

    <div class="container border p-3">
      <h2>Criar uma conta</h3>
        <?php
        if ($geraFormulario == "Sim") {
        ?>
          <form action="#" method="POST">
            <div class="form-group">
              <label for="form-login-input">Código de Utilizador</label>
              <input type="text" class="form-control" name="formUser" value="<?php echo $username; ?>" id="form-login-input">
              <p><?php echo $errorMessageUsername; ?></p>
            </div>
            <div class="form-group">
              <label for="form-email-input">E-mail</label>
              <input type="email" class="form-control" name="formEmail" value="<?php echo $username; ?>" id="form-email-input">
              <p><?php echo $errorMessageEmail; ?></p>
            </div>
            <div class="form-group">
              <label for="password1-login-input">Senha</label>
              <input type="password" class="form-control" name="formPassword1" value="<?php echo $password; ?>" id="password1-login-input">
              <p><?php echo $errorMessagePassword; ?></p>
            </div>
            <div class="form-group">
              <label for="password2-login-input">Confirmação de Senha</label>
              <input type="password" class="form-control" name="formPassword2" value="<?php echo $passwordConfirmation; ?>" id="password2-login-input">
              <p><?php echo $errorMessagePasswordRecover; ?></p>
            </div>
            <div class="form-group">
              <label for="fName-login-input">Nome</label>
              <input type="text" class="form-control" name="formfName" value="<?php echo $fName; ?>" id="fName-login-input">
              <p><?php echo $errorMessagefName; ?></p>
            </div>
            <div class="form-group">
              <label for="lName-login-input">Apelido</label>
              <input type="text" class="form-control" name="formlName" value="<?php echo $lName; ?>" id="lName-login-input">
              <p><?php echo $errorMessagelName; ?></p>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="formAceito" value="aceito_marketing" id="flexCheckDefault" <?php if ($aceitoMarketing == 1) {
                                                                                                                                  echo "checked";
                                                                                                                                } ?>>
              <label class="form-check-label" for="flexCheckDefault">
                Aceito que os meus dados sejam utilizados para efeitos de marketing
              </label>
            </div>

            <button class="btn mt-3" id="btn-customized" name="submit-create-account" type="submit">CRIAR CONTA <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
                <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z" />
              </svg></button>
          </form>
        <?php
        } else {
        ?>
          <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
          </svg>
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
              </svg> Conta criada com sucesso!</h4>
            <p><b><?php echo $temporaryMsg; ?></b></p>
            <hr>
            <form action="../home" method="POST">
              <button class="btn btn-success" type="submit">VOLTAR</button>
            </form>
          </div>
        <?php
        }
        ?>
    </div>
  </main>
  <?php include_once '../components/footer.php'; ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>