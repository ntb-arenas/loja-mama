<?php
session_start();
require "dbConfig.php";

  if (isset($_GET['action']))
  {
    if($_GET["action"] == "remove")
  	{
  		foreach($_SESSION["shopping_cart"] as $keys => $values)
  		{
  			if($values["id_produto"] == $_GET["id_produto"])
  			{
  				unset($_SESSION["shopping_cart"][$keys]);
        }
      }
    }
    if($_GET["action"] == "clear")
    {
      unset($_SESSION["shopping_cart"]);
      
    }
  }
?>

  <?php
  if(!empty($_SESSION["shopping_cart"]))
  { ?>
              <?php
            }
            ?>
            
          </table>
          <a href="index.php" class="btn btn-outline-secondary" style="width:13em;"><i class="fas fa-arrow-left"></i> Keep buying</a>
          <span style="float:right;">
              <form method='GET' action=''>
                <input type='hidden' name='id_produto' value="<?= $product["id_produto"]; ?>" />
                <input type='hidden' name='action' value="clear"/>
                <button class="btn btn-outline-secondary" value="" ><i class="far fa-trash-alt"></i> Clear cart</button>
              </form>
      </div>
      <div class="col-sm-4 col-md-4 col-xs-4">
        <h4>Resume</h4>
          <div class="row">
            <div class="col-md-4">
              <p>Subtotal:</p>
              <p> Iva:</p>
              <p> Shipping:</p>
              <p> <h5>Total:</h5></p>
            </div>
           
      </div>
      <div class="row">
        <?php
          $idu = $_SESSION["id_utilizador"];
          $info = "SELECT * FROM utilizador_info WHERE id_utilizador = $idu";
          $result6 = $conn->query($info);
          if($result6->num_rows > 0)
          {
            ?>
            <a href="checkout.php" class="btn btn-success" name="prod_submit" type ="submit" style="width:13em;">Checkout <span><i class="fas fa-play"></i></span></a>
            <?php
          }
          else
          {?>
          <a href="account.php" class="btn btn-danger" style="width:13em;">Delivery information <span><i class="fas fa-play"></i></span></a>
          <?php
        }
         ?>

      </div>
    </div>
<?
?>
</div>
</div>
</section>
  <section id="also liked">
  <div class="container">
    <div class="hr"></div>
    <h4 style="text-align:left;">Also may like</h4>
    <div class="row">
      <?php

      if(!empty($_SESSION["shopping_cart"]))
      
        /*Pesquisa com tags similares */
        /*Fim Tags Similares

        /*Produto não existe no carrinho */
        $query_carrinho = [];
        foreach ($_SESSION["shopping_cart"] as $code => $produto)
        {
          $query_carrinho[] = "id_produto != $code";
        }
        if (count($query_carrinho) > 0)
        {
          $query_carrinho = "WHERE " . implode(" AND ", $query_carrinho);
        }
        else
        {
          $query_carrinho = "";
        }
    
    /*Fim Produto não existe no carrinho */
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
          while($row = $result -> fetch_assoc())
          {
                $nome= $row["nome"];
                $ep = $row["episodios"];
                $estudio = $row["estudio"];
                $exibi = $row["exibido"];
                $nota = $row["nota"];
                $image = $row["image"];
                $sin = $row["sinopse"];
                $id = $row["id_produto"];
 ?>
 <div class="col-sm-2 col-xs-2 col-md-2">
   <div class="card">
         <a href="product.php?id_produto=<?= $id ?>" title="<?= $nome; ?>" data-toggle="popover" data-trigger="hover" data-html="true" data-content='
         <div style="width:400px;">
             <span> <i class="fas fa-tv"></i> <?= $ep; ?> Episodes</span> |
             <span> <?= $estudio; ?> </span> |
             <span> <i class="far fa-calendar-alt"></i> <?= $exibi; ?></span> |
             <span> <i class="far fa-star"></i> <?= $nota; ?></span>
         </div>
           <div class="clearfix" style="margin:8px 0;width:400px;">
             <p><?= $sin; ?></p>
           </div>'>
         <img class="card-img" src="images/anime/<?= $image; ?>" alt="image">

       <div class="card-footer">
         <h6 class="show_name"><?= $nome; ?></h6></a>
         <a href="cart_veri.php?id_produto=<?= $id; ?>" class="btn btn-outline-success btn-sm btn-block" style="display:inline-block;margin-bottom:1em;">
           <i class="fas fa-plus"></i> Add to cart!
         </a>
       </div>
    </div>
  </div>
<?php
      }
    }
?>
    </div>
  </div>
  </section>
</section>
</br>
<?php include("footer.php");?>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});
</script>
<script>
$(document).ready(function () {
    $(document).on('mouseenter', '.divbutton', function () {
        $(this).find(":button").show();
    }).on('mouseleave', '.divbutton', function () {
        $(this).find(":button").hide();
    });
});
</script>
<script>
var precototal = document.querySelector("#preco_total");
var subtotal = document.querySelector("#subtotal");
var ivatotal = document.querySelector("#ivatotal");
function updateTotal()
{
  var total = 0;
  for (var element of document.querySelectorAll("#qnt"))
  {
    if (Number(element.value) > element.dataset.maxstock)
    {
      element.value = element.dataset.maxstock;
    } else if (Number(element.value) < 0) {
      element.value = 1;
    }

    var preco = Number(element.dataset.preco) * Number(element.value);
    element.parentElement.parentElement.querySelector("#preco").innerText = preco.toFixed(2);
    total += preco;
  }
  subtotal.innerText = "€ " + total.toFixed(2);
  ivatotal.innerText = "€ " + (total * 0.23).toFixed(2);
  precototal.innerText = "€ " + (total * 1.23 + 5).toFixed(2);
}
function updateQnt(element,id_produto)
{
  var qnt = element.value;
  $.post(
    "cart_veri.php",
    { updateQnt: 'updateQnt', id_produto: id_produto, qnt: qnt },
    function (response)
    {
      console.log(response);
    });
}
updateQnt();
updateTotal();
</script>
