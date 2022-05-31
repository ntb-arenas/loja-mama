<?php

session_start();
include_once  '../login/connect_DB.php';

$username = $_SESSION["USER"];

$stmt = $_conn->prepare('SELECT * FROM USERS WHERE USERNAME = ?');
$stmt->bind_param('s', $username);
$stmt->execute();

$usersResult = $stmt->get_result();

if ($usersResult->num_rows > 0) {
    while ($rowUsers = $usersResult->fetch_assoc()) {
        $morada = $rowUsers['MORADA'];
        $telemovel = $rowUsers['TELEMOVEL'];
        $cidade = $rowUsers['CIDADE'];
        $codPostal = $rowUsers['COD_POSTAL'];
        $pais = $rowUsers['PAIS'];
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

        <div class="container-md">
            <div class="row">
                <div class="col-12 col-md-3 mb-3">
                    <div class="list-group list-group-light d-none d-md-block">
                        <a href="./profile-account" class="list-group-item list-group-item-action px-3 border-0 active" id="account-style" aria-current="true">INFORMAÇÕES DA CONTA</a>
                        <a href="./encomendas" class="list-group-item list-group-item-action px-3 border-0">AS MINHAS ENCOMENDAS</a>
                        <a href="./edit-account" class="list-group-item list-group-item-action px-3 border-0">EDITAR CONTA</a>
                        <a href="./favorite" class="list-group-item list-group-item-action px-3 border-0">LISTA DE DESEJOS</a>
                        <a href="./reviews" class="list-group-item list-group-item-action px-3 border-0">REVIEWS</a>
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
                                                <a href="./profile-account" class="list-group-item list-group-item-action px-3 border-0 active" id="account-style" aria-current="true">INFORMAÇÕES DA CONTA</a>
                                                <a href="./encomendas" class="list-group-item list-group-item-action px-3 border-0">AS MINHAS ENCOMENDAS</a>
                                                <a href="./edit-account" class="list-group-item list-group-item-action px-3 border-0">EDITAR CONTA</a>
                                                <a href="./favorite" class="list-group-item list-group-item-action px-3 border-0">LISTA DE DESEJOS</a>
                                                <a href="./reviews" class="list-group-item list-group-item-action px-3 border-0">REVIEWS</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9 border-start mt-3 mt-md-0">
                    <h4>INFORMAÇÃO DE CONTACTO</h4>
                    <p><?php echo $_SESSION["FIRSTNAME_USER"] . " " . $_SESSION["LASTNAME_USER"] ?></p>
                    <p><?php echo $_SESSION["EMAIL_USER"] ?></p>

                    <h4 class="info_cont">MORADA</h4>
                    <p><?php echo $_SESSION["FIRSTNAME_USER"] . " " . $_SESSION["LASTNAME_USER"]; ?></p>
                    <p><?php echo $morada; ?></p>
                    <p><?php echo $codPostal . ", " . $cidade; ?></p>
                    <p><?php echo $pais; ?></p>
                    <p><?php echo "T: " . $telemovel; ?></p>
                </div>
            </div>
        </div>

    </main>
    <?php include_once '../components/footer.php'; ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>

</html>