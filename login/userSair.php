<?php 
session_start();

// É possível fazer o unset específico a determinadas variáveis de sessão
// exemplo:
// unset($_SESSION["UTILIZADOR"]);

// Ou simplesmente destruir a sessão...
//
session_destroy();

header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
header("Location: ../home");

 
?>
<html>
</html>
