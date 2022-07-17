<?php error_reporting (E_ALL); ?>

<?php include_once './dbConfig.php'; ?>

<link rel="shortcut icon" type="image/png" href="img/favicon.ico">
<script src="https://kit.fontawesome.com/cdf55d327b.js" crossorigin="anonymous"></script>

<div class="w3-top w3-black">
  <div class="w3-bar w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="./index.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Inicio</a>
    <a href="./contacto.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Contacto</a>
    <a href="./viewCart.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white"><?php echo ($cart->total_items() > 0)?$cart->total_items().' ':' '; ?><i class="fab fa-solid fa-cart-shopping"></i></a>
      <?php if (isset($_SESSION["UTILIZADOR"]) ) { ?>
        <a href="./userSair.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white">Sair</a>
        <a href="./userEditarConta.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white"><?php echo $_SESSION["UTILIZADOR"];?></a>
      <?php } else { ?>
       <!-- <a href="./userEntrar.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white">Login</a>-->
      <?php } ?>
  </div>
</div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-large">
    <a href="./index.php" class="w3-bar-item w3-button w3-padding-large">Inicio</a>
    <a href="./loja.php" class="w3-bar-item w3-button w3-padding-large">Loja</a>
    <a href="./contacto.php" class="w3-bar-item w3-button w3-padding-large">Contacto</a>
    <a href="./checkout.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white"><i class="fab fa-solid fa-cart-shopping"></i></a>
    <?php if (isset($_SESSION["UTILIZADOR"]) ) { ?>
        <a href="./userSair.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white">Sair</a>
        <a href="./userEntrar.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white"><?php echo $_SESSION["UTILIZADOR"];?></a>
      <?php } else { ?>
        <!--<a href="./userEntrar.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white">Login</a>-->
      <?php } ?>
    </div>
</div>

<script>
// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>