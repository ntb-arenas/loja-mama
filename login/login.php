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

    $stmt = $_conn->prepare('SELECT * FROM USERS WHERE USERNAME = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $usersResult = $stmt->get_result();

    if ($usersResult->num_rows > 0) {
        while ($rowUsers = $usersResult->fetch_assoc()) {

            if ($rowUsers['USER_STATUS'] == 2) { // BLocked user

                $errorMessagePassword = "Não é possível entrar no sistema. Contacte os nossos serviços para obter ajuda.";
            } else  if ($rowUsers['USER_STATUS'] == 0) { // User account created but not verified

                $errorMessagePassword =  $rowUsers['fNAME'] . ", ainda não ativou a sua conta. A mensagem com o código inicial de ativação de conta foi enviada para a sua caixa de correio. Caso não a encontre na sua caixa de entrada, verifique também o seu correio não solicitado ou envie-nos um email para ativarmos a sua conta. Obrigado.";
            } else  if (password_verify($password, $rowUsers["PASSWORD"])) {

                $_SESSION["USER"] = $rowUsers["USERNAME"];
                $_SESSION["LEVEL_USER"] = $rowUsers["USER_STATUS"];
                $_SESSION["FIRSTNAME_USER"] = $rowUsers["fNAME"];
                $_SESSION["LASTNAME_USER"] = $rowUsers["lNAME"];
                $_SESSION["EMAIL_USER"] = $rowUsers["EMAIL"];


                header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
                header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
                header("Location: ../home");
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
                                <p><?php echo $errorMessagePassword; ?></p>
                            </div>
                            <div class="recuperarSenha mt-3">
                                <a class="link-dark" style="color: gray!important;" href="./userRecuperarSenha.php">Esqueceu-se da palavra-passe?</a>
                            </div>
                            <button class="btn mt-3" id="btn-customized" name="button-login" type="submit">INICIAR SESSÃO <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                                    <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
                                    <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z" />
                                </svg></button>
                        </form>
                </div>
                <div class="col-12 col-md-6 mt-5" id="login-page-divider1">
                    <h2 class="text-center pt-3" id="login-page-divider2">Criar Conta</h3>
                        <div class="container-fluid text-center">
                            <a href="./create-account" class="btn" id="btn-customized" role="button">
                                CRIAR CONTA <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg>
                            </a>
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