<?php

session_start();
error_reporting(E_ERROR | E_PARSE);

include_once  './connect_DB.php';


if (isset($_POST['btn-cancel-changes'])) {
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
    header("Location: ../home");
}

if (isset($_POST['btn-forgot-pass'])) {

    session_destroy(); // destruição imediata de sessão

    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
    header("Location: ../userRecuperarSenha.php");
}




$temporaryMsg = "";

$errorMessagefName = "";
$errorMessagelName = "";
$errorMessagePassword = "";
$errorMessageEmail = "";

$geraFormulario = "Sim";

if (!isset($_SESSION["USER"])) {
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
    header("Location: home");
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

            if (!isset($_POST["fName"], $_POST["lName"], $_POST["email"])) {

                $fName = $rowusers['fNAME'];
                $lName = $rowusers['lNAME'];
                $email = $rowusers['EMAIL'];
            } else {

                $podeRegistar = "Sim";

                $fName = mysqli_real_escape_string($_conn, $_POST['fName']);
                $fName = trim($fName);
                $lName = mysqli_real_escape_string($_conn, $_POST['lName']);
                $lName = trim($lName);
                $email = mysqli_real_escape_string($_conn, $_POST['email']);
                $lName = trim($lName);

                if (strlen(trim($fName)) < 2) {
                    $errorMessagefName = "O nome é demasiado curto!";
                    $podeRegistar = "Nao";
                }

                if (strlen(trim($lName)) < 2) {
                    $errorMessagelName = "O apelido é demasiado curto!";
                    $podeRegistar = "Nao";
                }
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorMessageEmail = "O e-mail não é válido!";
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

        $email = strip_tags($email);
        $fName = strip_tags($fName);
        $lName = strip_tags($lName); // demonstração da remoção de caracteres especiais html por exemplo..

        $sql = "UPDATE users SET fNAME = ?, lNAME = ?, EMAIL = ? WHERE USERNAME = ?";

        if ($stmt = mysqli_prepare($_conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "ssss", $fName, $lName, $email, $username);


            mysqli_stmt_execute($stmt);

            $temporaryMsg = "Definições de conta alteradas com sucesso.";

            // atualizar variável de sessão, a questão de receber mensagens de marketing não
            // é uma variável de sessão, não é necessário guardar em sessão.

            $_SESSION["FIRSTNAME_USER"] = $fName;
            $_SESSION["LASTNAME_USER"] = $lName;
            $_SESSION["EMAIL_USER"] = $email;

            // encaminhar com timer 3 segundos
            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
            header("Refresh: 3; URL=../profile-account");
        } else {
            // echo "ERROR: Could not prepare query: $sql. " . mysqli_error($_conn);
            echo "STATUS ADMIN (alterar definições): " . mysqli_error($_conn);
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
    <title>Ma-Ma Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="shortcut icon" href="../gallery/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
  <?php include_once '/components/header.php'; ?>
  <?php include_once '/components/navbar.php'; ?>
    <main>

        <div class="information-container">
            <div class="sidebar-main">
                <div class="customer-area">
                    <h1>
                        Olá <?php echo $_SESSION["FIRSTNAME_USER"] ?>
                    </h1>
                    <h3><a href="./usersair.php">Logout</a></h3>
                </div>

                <div class="account-panel">
                    <h3>PAINEL DE CONTA</h3>
                    <div class="account-panel-wrapper">
                        <p><a href="../profile-account">A MINHA CONTA</a></p>
                        <p><a href="#">AS MINHAS ENCOMENDAS</a></p>
                        <p><a href="#">SUBSCRIÇÃO MARKETING</a></p>
                    </div>
                </div>
            </div>

            <div class="information-component">
                <h1>Editar Conta</h1>
                <br>
                <div class="editAcc-box">
                    <div class="information-editAcc-content">
                        <form action="#" method="POST">
                            <fieldset class="editAcc-fieldset">
                                <legend>Nome</legend>
                                <div class="div-input">
                                    <input type="text" class="editAcc-input" name="fName" value="<?php echo $fName; ?>">
                                </div>
                            </fieldset>

                            <div class="div-errors">
                                <p><?php echo $errorMessagefName; ?></p>
                            </div>
                            <br>
                            <fieldset class="editAcc-fieldset">
                                <legend>Apelido</legend>
                                <div class="div-input">
                                    <input type="text" class="editAcc-input" name="lName" value="<?php echo $lName; ?>">
                                </div>
                            </fieldset>
                            <div class="div-errors">
                                <p><?php echo $errorMessagelName; ?></p>
                            </div>
                            <br>

                            <input type="checkbox" id="myCheck" name="email-change" onclick="myFunction()">
                            <label for="email-change">Alterar E-mail</label>

                            <fieldset id="text" style="display: none;" class="editAcc-fieldset">
                                <legend>Email</legend>
                                <div class="div-input">
                                    <input type="text" class="editAcc-input" name="email" value="<?php echo $email; ?>">
                                </div>
                            </fieldset>
                            <div class="div-errors">
                                <p><?php echo $errorMessageEmail; ?></p>
                            </div>
                            <br>

                            <p>Por uma questão de segurança, para alterar as suas definições de conta deverá digitar a
                                sua senha. No final, não se esqueça de gravar as alterações.
                                Se apenas pretende alterar a sua senha use a opção "Esqueci-me da senha".</p>
                            <fieldset class="editAcc-fieldset">
                                <legend>Senha atual</legend>
                                <div class="div-input">
                                    <input type="password" class="editAcc-input" name="password" value="<?php echo $password; ?>">
                                </div>
                            </fieldset>
                            <div class="div-errors">
                                <p><?php echo $errorMessagePassword; ?></p>
                            </div>

                            <div class="btn-editAcc">
                                <div class="div-btn-profile">
                                    <button class="btn-profile" name="btn-save-changes" type="submit"><span>GRAVAR ALTERAÇÕES</span></button>
                                </div>
                                <div class="div-btn-profile">
                                    <button class="btn-profile" name="btn-cancel-changes" type="submit"><span>CANCELAR ALTERAÇÕES</span></button>
                                </div>

                        </form>
                        <div class="div-btn-profile">
                            <form action="./userRecuperarSenha.php">
                                <button class="btn-profile" name="btn-cancel-changes" type="submit"><span>RECUPERAR SENHA</span></button>
                            </form>
                        </div>
                    </div>
                    <p><b><?php echo $temporaryMsg; ?></b></p>
                    <br>
                </div>
            </div>
    </main>
    <?php include_once '../components/footer.php'; ?>
</body>

<script src="../js/script.js"></script>

</html>