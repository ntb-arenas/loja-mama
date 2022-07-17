<?php
session_start();
include('dbConfing.php');

    if (isset($_GET['id_produto']) && $_GET['id_produto']!="")
    {

      $code = $_GET['id_produto'];
      $sql="SELECT id_produto,nome,preco,image FROM produto WHERE id_produto=$code";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_assoc($result);
      $name = $row['name'];
      $code = $row['id'];
      $price = $row['price'];
      $image = $row['img'];
      $qnt = 1;
      $product = [
        'name' => $name,
        'id_produto' => $code,
        'price' => $price,
        'img' => $image,
        'qnt'   => $qnt
      ];

      if(empty($_SESSION["shopping_cart"]))
      {
          $_SESSION["shopping_cart"] = [ $code => $product ];
      }
      else
      {
        if(isset($_SESSION["shopping_cart"][$code])) {
          echo'<h3>Product already in cart</h3>';
        }
        else
        {
          $_SESSION["shopping_cart"][$code] = $product;
        }
      }
    }
    if(isset($_POST['updateQnt']) == "updateQnt" )
    {
      foreach ($_SESSION['shopping_cart'] as $key => $value)
      {
        if($_POST["id"] == $value["id"])
        {
          $_SESSION["shopping_cart"][$key]["qnt"] = $_POST["qnt"];
        }
      }
    }

    header("location:cart.php");
{
  header("location:login.php");
}

?>
