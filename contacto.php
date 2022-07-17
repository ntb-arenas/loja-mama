
<?php include_once './dbconfig.php'; ?>
<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>

<title>Suporte</title>
<link rel="shortcut icon" type="image/png" href="img/favicon.ico">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">

<!-- Second Grid -->
    <div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
        <div class="w3-content w3-center">
            <div class="w3-third">
                <i class="w3-padding-64 w3-text-red w3-margin-right "></i>
            </div>
                <div class="w3-row">
                    <h1>Suporte 24/7</h1>
                    <p class="w3-text-grey w3-center">Responderemos o mais rápido possível a qualquer dúvida</p>
                    <div clas="form-group">
                        <form action="suporte.php" method="POST">

							<p>
								<input type="text" placeholder="Nome" name="nome" id="nome">
								<input type="email" placeholder="Email" name="email" id="email">
							</p>

							<p>
								<input type="text" placeholder="Assunto" name="assunto" id="assunto">
							</p>
                            
							<p><textarea name="mensagem" id="mensagem" cols="30" rows="10" placeholder="Mensagem"></textarea></p>
							<p><input type="submit" value="Enviar" name="suporte"></p>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once './footer.php'?>
<?php include_once './navbar.php'?>
