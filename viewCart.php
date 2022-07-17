<?php 
// Initialize shopping cart class 
include_once 'Cart.class.php'; 
require_once 'dbConfig.php';
$cart = new Cart; 
include_once './navbar.php';
?>

<!DOCTYPE html>

<html lang="en">

<head>
<title>Jundi Smoke</title>
<link rel="shortcut icon" type="image/png" href="img/favicon.ico">

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
<didv class="row">



<!-- Header -->
<header class="w3-container w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo"><font color="orange">Jundi</font><font color="white">Smoke</h1></font>
</header>
<div class="container">
 
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom style -->
<link href="css/style.css" rel="stylesheet">

<!-- jQuery library -->
<script src="js/jquery.min.js"></script>

<script>
function updateCartItem(obj,id){
    $.get("cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
        if(data == 'ok'){
            location.reload();
        }else{
            alert('Cart update failed, please try again.');
        }
    });
}
</script>
</head>
<body>
<div class="container">
<br><br>    
<h1>CARRINHO DE COMPRAS</h1>
    <div class="row">
        <div class="cart">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="45%">Produtos</th>
                                <th width="10%">Sabor</th>
                                <th width="10%">Preço</th>
                                <th width="15%">Quantidade</th>
                                <th class="text-right" width="20%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($cart->total_items() > 0){ 
                                // Get cart items from session 
                                $cartItems = $cart->contents();
                                foreach($cartItems as $item){

                                $id_sabor = $db->query("SELECT sabor FROM sabores WHERE id = $item[id_sabor]");
                                    if($id_sabor->num_rows > 0){  
                                        while($row = $id_sabor->fetch_assoc()){

                            ?>
                            <tr>
                                <td><?php echo $item["name"]; ?></td>

                                <td><?php echo $row['sabor']; ?></td>

                                <td id="price" value="<?php echo $item["price"]?>"><?php echo 'R$'.$item["price"]; ?>.00</td>

                                <td><input class="form-control" type="number" value="1" id="qty<?php echo $item["id"]?>" onChange = "updateQty(<?php echo $item["price"]?>,<?php echo $item["id"]?>)"></td>

                                <td id="subtotal<?php echo $item["id"]?>" class="text-right"><?php echo 'R$'.$item["subtotal"]; ?>.00</td>

                                <td class="text-right"><button class="btn btn-sm btn-danger" onclick="return confirm('Tem Certeza?')?window.location.href='cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>':false;"><i class="itrash">Remover</i> </button> </td>

                            </tr>
                            <?php } } } } else{ ?>
                            <tr><td colspan="5"><p>Seu carrinho está vazio.....</p></td>
                            <?php } ?>
                            <?php if($cart->total_items() > 0){ ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><strong>Total de compras</strong></td>
                                <td class="text-right"><strong><?php echo 'R$'.$cart->total(); ?>.00</strong></td>
                                <td></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                        <a href="index.php" class="btn btn-block w3-blue">Continuar as compras</a>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right">
                        <?php if($cart->total_items() > 0){ ?>
                        <a href="checkout.php" class="btn btn-lg btn-block btn-primary">Finalizar pedido</a>
                        <?php } ?>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">

    function updateQty(price, id) {

        var qty = document.getElementById("qty" + id);
        var current = parseInt(qty.value);
        var total = current * price;
        var sub = "subtotal" + id;
        var p = document.getElementById(sub);
        p.innerHTML = "R$ " + total.toFixed(2);
        
    }
    
</script>


<?php include_once './footer.php'?>