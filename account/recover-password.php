<?php

session_start();
error_reporting(E_ERROR | E_PARSE);


include_once  '../login/connect_DB.php';
include_once '../login/function_mail_utf8.php';

$mensagemErrousername = "";
$mensagemErroSenha = "";
$mensagemErroEmail = "";
$geraFormulario = "Sim";



if (isset($_POST['botao-recuperar-senha'])) {

    $username = mysqli_real_escape_string($_conn, $_POST['formusername']);
    $username = strtolower(trim($username));


    $stmt = $_conn->prepare('SELECT * FROM USERS WHERE USERNAME = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $resultadoUsers = $stmt->get_result();

    if ($resultadoUsers->num_rows > 0) {
        while ($rowUsers = $resultadoUsers->fetch_assoc()) {

            $fName = $rowUsers['fNAME'];
            $lName = $rowUsers['lNAME'];

            if ($rowUsers['USER_STATUS'] == 2) { // utilizador bloqueado

                $mensagemErroSenha = "Não foi enviada mensagem de recuperação de senha, contacte os nossos serviços para obter ajuda.";
            } else  if ($rowUsers['USER_STATUS'] == 0) { // Utilizador criou a conta mas não ativou

                $mensagemErroSenha =  $rowUsers['fNAME'] . ", ainda não ativou a sua conta. A mensagem com o código inicial de ativação de conta foi enviada para a sua caixa de correio. Caso não a encontre na sua caixa de entrada, verifique também o seu correio não solicitado ou envie-nos um email para ativarmos a sua conta. Obrigado.";
            } else {

                // Recuperar a senha 
                // gerar token, preparar e enviar mail de recuperação

                $code = md5(uniqid(rand()));

                $sql = "UPDATE USERS SET TOKEN_CODE=? WHERE USERNAME=?";

                if ($stmt = mysqli_prepare($_conn, $sql)) {

                    mysqli_stmt_bind_param($stmt, "ss", $code, $username);
                    mysqli_stmt_execute($stmt);

                    // Update efetuado com sucesso, preparar e enviar mensagem 
                    $id = base64_encode($username);

                    $urlPagina = "https://ntbarenas.000webhostapp.com/login/";


                    $mensagem = "Caro(a) $fName" . "," . "\r\n" .  "\r\n" .


                        "Foi-nos pedido para recuperar a sua senha. Se nos pediu isto basta seguir as instruções seguintes, caso contrário, ignore esta mensagem." . "\r\n" .  "\r\n" .

                        "Para recuperar agora a sua senha basta carregar na seguinte ligação:" . "\r\n" . "\r\n" .

                        $urlPagina . "userNovaSenha.php?id=$id&code=$code" . "\r\n" . "\r\n" .

                        "Esta mensagem foi-lhe enviada automaticamente.";

                    $subject = "Recuperação da sua senha em $urlPagina";

                    // use wordwrap() if lines are longer than 70 characters
                    $mensagem = wordwrap($mensagem, 70);

                    // send email
                    mail_utf8($email, $subject, $mensagem);
                    // echo $mensagem; // apenas para efeitos de teste...
                    //$msgTemporaria = $email . " " . $subject . " " . $mensagem;
                    // mail enviado

                    $mensagemEmail = " " . "$nome, verifique por favor a sua caixa de correio para recuperar de imediato a sua senha!";

                    // fim do envio de mensagem //////////////////////////////////////////////////////////////////            

                    $geraFormulario = "Nao";
                } else {
                    // erro
                    echo "STATUS ADMIN (recuperar senha): " . mysqli_error($_conn);
                }
            }
        }
    } else {
        $mensagemErrousername = "O código de utilizador não existe na nossa base de dados!";
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
    <title>Ma-Ma</title>
    <!-- stylesheet ---------------------------->
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.css" rel="stylesheet" />
    <!-- page icon --------------------------------->
    <link rel="shortcut icon" href="../gallery/logo.png">
    <!-- fonts ------------------------------------------>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
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

        <div class="container border p-3 mt-3">
            <h2>Recuperar senha</h2>
            <?php
            if ($geraFormulario == "Sim") {
            ?>
                <form action="#" method="POST">
                    <div class="form-group">

                        <label for="form-login-input">Código de Utilizador</label>
                        <input type="text" class="form-control mb-2" name="formusername" value="<?php echo $username; ?>" id="form-login-input">
                        <?php
                        if (empty($mensagemErrousername)) {
                        } else {
                        ?>
                            <span class="alert alert-danger p-2" role="alert">
                                <?php echo $mensagemErrousername; ?>
                            </span>
                        <?php
                        }
                        ?>
                    </div>
                    <button class="btn mt-3" id="btn-customized" name="botao-recuperar-senha" type="submit">RECUPERAR SENHA</button>
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
                    <p><b>Verifique por favor a sua caixa de correio para recuperar a senha! Por vezes estas mensagens são consideradas correio não solicitado. Se não vir a mensagem de ativação verifique o seu correio não solicitado (SPAM).</p>
                    <hr>
                    <form action="../index.php" method="POST">
                        <button class="btn btn-success" type="submit">VOLTAR</button>
                    </form>
                </div>
            <?php
            }
            ?>
        </div>

        <?php include_once '../components/footer.php'; ?>
    </main>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>