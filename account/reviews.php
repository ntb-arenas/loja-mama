<?php

session_start();
error_reporting(E_ERROR | E_PARSE);

include_once  '../login/connect_DB.php';

$temporaryMsg = "";
$errorMessageMessage = "";

$message = "";

if (!isset($_SESSION["USER"])) {
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
    header("Location: ../home");
} else {
    // ler informações de conta 
    $username = $_SESSION["USER"];

    $stmt = $_conn->prepare('SELECT * FROM USERS WHERE USERNAME = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $usersResult = $stmt->get_result();

    if ($usersResult->num_rows > 0) {
        while ($rowUsers = $usersResult->fetch_assoc()) {

            if (!isset($_POST["fName"], $_POST["lName"])) {
                $fName = $rowUsers['fNAME'];
                $lName = $rowUsers['lNAME'];
                $reviewId = $rowUsers['ID'];
            } else {
                $podeRegistar = "Sim";
                $fName = mysqli_real_escape_string($_conn, $_POST['fName']);
                $fName = trim($fName);
                $lName = mysqli_real_escape_string($_conn, $_POST['lName']);
                $lName = trim($lName);
            }
        }
    } else {
        echo "STATUS ADMIN (Editar conta): " . mysqli_error($_conn);
    }
    mysqli_stmt_close($stmt);
}


$mensagemUpload = "";

if (isset($_POST['btn-save-changes'])) {
    $message = mysqli_real_escape_string($_conn, $_POST['formMessage']);
    $message = strip_tags($message);

    $pasta = "../gallery/reviews/";
    $pastaPublicacao = trim($_SESSION["USER"]);
    $pasta = $pasta . $pastaPublicacao;
    mkdir($pasta, 0777, true);
    $pasta = $pasta . "/";
    // $target_dir = "./uploads/";
    $target_dir = $pasta;
    $nomeSemEspacos = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($_FILES['fileToUpload']["name"]));
    $target_file = $target_dir . $nomeSemEspacos;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $mensagemUpload = $mensagemUpload . "O ficheiro é uma imagem - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $mensagemUpload = $mensagemUpload . "O ficheiro não é uma imagem.";
            $uploadOk = 0;
        }
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 15000000) {
        $mensagemUpload = $mensagemUpload . "A imagem é demasiado grande. Tamanho máximo = 12MB.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $mensagemUpload = $mensagemUpload . "Apenas são permitidos ficheiros JPG, JPEG, PNG e GIF.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $mensagemUpload = $mensagemUpload . "Desculpe, o ficheiro não foi carregado.";
        $podeRegistarImage = "Nao";
        // if everything is ok, try to upload file
    } else {
        // Check if file already exists
        if (file_exists($target_file)) {
            // remover a imagem no servidor
            if (file_exists($target_file)) unlink($target_file);
            $mensagemUpload = $mensagemUpload . "A imagem anterior foi substituída."; // na realidade removida
            // $mensagemDivulgacao = $mensagemDivulgacao . "Sorry, file already exists.";
            // $uploadOk = 0;
        }
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $mensagemUpload = $mensagemUpload . " O ficheiro " . basename($_FILES["fileToUpload"]["name"]) . " foi carregado com sucesso.";
            $podeRegistarImage = "Sim";
            // foi feito o upload
        } else {
            $mensagemUpload = $mensagemUpload .  "Desculpe, verificou-se um erro no carregamento do ficheiro.";
        }
        // $mensagemUpload = $mensagemUpload . basename($_FILES["fileToUpload"]["name"]);
    }

    if (empty($message)) {
        $errorMessageMessage = "Mensagem é demasiado curto";
        $podeRegistar = "Nao";
    } else {
        $podeRegistar = "Sim";
    }

    if ($podeRegistar == "Sim" && $podeRegistarImage == "Sim") {
        ///////////////////////////////////
        // ALTERA/INSIRA
        //////////////////////////////////

        $img_url = "gallery/reviews/" . $pastaPublicacao . "/" . $nomeSemEspacos;
        $userId = $reviewId.'-review';

        $sql = mysqli_query($_conn, "SELECT * FROM REVIEWS");
        $sql = "INSERT INTO REVIEWS (USER_ID, DESCRIPTION, IMAGE_URL) VALUES (?,?,?)";

        if ($stmt = mysqli_prepare($_conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "sss", $userId, $message, $img_url);

            mysqli_stmt_execute($stmt);

            $temporaryMsg = "Sucesso!";


            // encaminhar com timer 3 segundos
            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
            header("Refresh: 3; URL=./reviews");
        } else {
            // echo "ERROR: Could not prepare query: $sql. " . mysqli_error($_conn);
            echo "STATUS ADMIN (alterar definições): " . mysqli_error($_conn);
        }
        mysqli_stmt_close($stmt);


        // Update user review ID
        $sql = mysqli_query($_conn, "SELECT * FROM USERS");
        $sql = "UPDATE USERS SET REVIEW_ID=? WHERE USERNAME=?";

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
            <h5><a href="../login/userSair.php">Logout</a></h5>
        </div>

        <div class="container-md mb-3">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="list-group list-group-light d-none d-md-block">
                        <div class="list-group list-group-light">
                            <a href="./profile-account" class="list-group-item list-group-item-action px-3 border-0">INFORMAÇÕES DA CONTA</a>
                            <a href="./encomendas" class="list-group-item list-group-item-action px-3 border-0">AS MINHAS ENCOMENDAS</a>
                            <a href="./edit-account" class="list-group-item list-group-item-action px-3 border-0">EDITAR CONTA</a>
                            <a href="./favorite" class="list-group-item list-group-item-action px-3 border-0">LISTA DE DESEJOS</a>
                            <a href="./reviews" class="list-group-item list-group-item-action px-3 border-0  active" id="account-style" aria-current="true">REVIEWS</a>
                        </div>
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
                                                <a href="./favorite" class="list-group-item list-group-item-action px-3 border-0">LISTA DE DESEJOS</a>
                                                <a href="./reviews" class="list-group-item list-group-item-action px-3 border-0  active" id="account-style" aria-current="true">REVIEWS</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-9 mt-3 mt-md-0 border-start">
                    <div class="container border p-3">
                        <h2>Testemunho</h3>
                            <?php
                            if ($podeRegistar == 'Sim') { ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    <?php echo $temporaryMsg; ?>
                                </div>
                            <?php
                            }
                            ?>
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="form-login-input">Nome</label>
                                    <input type="text" class="form-control" disabled name="fName" value="<?php echo $fName; ?>" id="form-login-input">
                                    <p><?php echo $errorMessagefName; ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="form-login-input">Apelido</label>
                                    <input type="text" class="form-control" disabled name="lName" value="<?php echo $lName; ?>" id="form-login-input">
                                    <p><?php echo $errorMessagelName; ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="form-message-input">Message</label>
                                    <textarea class="form-control" name="formMessage" id="form-message-input" rows="4"></textarea>
                                    <p>
                                        <?php
                                        if ($podeRegistar == 'Nao') { ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        <?php echo $errorMessageMessage; ?>
                                    </div>
                                <?php
                                        }
                                ?>
                                </p>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="fileToUpload">Upload Image</label>
                                    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" />

                                    <p>
                                        <?php
                                        if ($podeRegistarImage == 'Nao') { ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        <?php echo $mensagemUpload; ?>
                                    </div>
                                <?php
                                        }
                                ?>
                                </p>
                                </div>

                                <button class="btn" id="btn-customized" name="btn-save-changes" type="submit">GRAVAR</button>
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