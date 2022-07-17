<?php 
// Initialize shopping cart class 
include_once 'Cart.Class.php'; 
$cart = new Cart; 
 
// Include the database config file 
require_once 'dbConfig.php'; 

include_once './navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

<title>Jundi Smoke</title>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
</style>

<body>
    <!-- Header -->
<header class="w3-container w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo"><font color="orange">Jundi</font><font color="white">Smoke</h1></font>
</header>
<div class="container">
    <div class="w3-center">
        <br>
        <br>
        <br>
        <br>
    <h1>Produtos</h1>
    <br>
        <br>
	

    <!-- Product list -->
    <div class="row col-lg-12">
        <?php 
        // Get products from database 
        $produto = $db->query("SELECT * FROM products ORDER BY id DESC LIMIT 10"); 
        if($produto->num_rows > 0){  
            while($row = $produto->fetch_assoc()){
                ?>
                 <div class="card col-lg-4">
            <div class="card-body" width="20px">
                <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Preço: <?php echo 'R$'.$row["price"]; ?></h6>
                <p class="card-text"> <img src=<?php echo $row['img'];?>> </p>
                <p class="card-text"><?php echo $row["description"]; ?></p>
                    <div class="select-class">
                         <select name="sabor<?php echo $row['id'];?>" id="sabor<?php echo $row['id'];?>" onChange="getSabor(<?php echo $row['id'];?>)">
                            <?php
                                $idsabor = $db->query("SELECT * FROM produto_sabor WHERE id_produto = $row[id]"); 
                                    if($idsabor->num_rows > 0){
                                        while($row2 = $idsabor->fetch_assoc()){
                                        $sabores = $db->query("SELECT `sabor` FROM sabores WHERE id= $row2[id_sabor]");   
                                            if($sabores->num_rows > 0){  
                                                while($row3 = $sabores->fetch_assoc()){
                                ?>
                            <option value="" selected disabled hidden>Escolher sabor</option>
                            <option value=<?php echo $row2['id_sabor'];?>> <?php echo $row3['sabor']?></option> 
                        <?php } } } } ?>
                        </select> 
                        <br><br>
                    </div>
                <a href="cartAction.php?action=addToCart&id=<?php echo $row["id"];?>" class=" w3-black btn btn-primary" id="<?php echo $row['id'];?>" >Adicionar ao carrinho</a>
                
            </div>
            <br>
        <br>
        <br>
        <br>
        </div>
                <?php } } else{ ?>
                    
                    <p>Product(s) não encontrado.....</p>
                <?php } ?>
                
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    function getSabor(ID) {
        var s = "sabor" + ID;
        var e = document.getElementById(s);
        var v = e.value;
        
        var link = document.getElementById(ID);
        link.href ="cartAction.php?action=addToCart&id=" + ID + "&" + "sid=" + v;
    }
       

</script>


<?php include_once './footer.php'?>