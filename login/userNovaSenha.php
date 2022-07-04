<?php 

session_start();

session_destroy(); // destruição incondicional de sessão

include_once  './conexaobasedados.php'; 


if (empty($_GET['id']) || empty($_GET['code'])) {
     header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
     header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
     header("Location: home");
     
}

$codigo ="";
$senha ="";
$senhaConfirmacao ="";
$nome ="";


$mensagem ="";

$geraForm = "Nao"; 
$interfaceSenhas = "Nao";
$sucesso = "Nao";

if (isset($_GET['id']) && isset($_GET['code'])) {
    
    
    $codigo = base64_decode($_GET['id']); 
    $code = $_GET['code'];
    
    $stmt = $_conn->prepare('SELECT * FROM users WHERE CODIGO = ? AND TOKEN_CODE= ?');
    $stmt->bind_param('ss', $codigo, $code); 
    $stmt->execute();

    $resultadousers = $stmt->get_result();
    
    if ($resultadousers->num_rows > 0) {
        while ($rowusers = $resultadousers->fetch_assoc()) {
             $geraForm="Sim";  
             $interfaceSenhas = "Sim";
             $nome= $rowusers["NOME"];
        }            
            
        } else {
           
           $mensagem = "O código de utilizador ou código de recuperação já foi utilizado ou danificado. Em caso de dificuldade, pode solicitar novamente a recuperação de senha.";
        } 
    
    mysqli_stmt_close($stmt);
   
           
}



if (isset($_POST['botao-guardar-nova-senha'])) {

    $podeAlterar ="Sim"; 
    
    $senha = $senha=mysqli_real_escape_string($_conn,$_POST["senha"]);
    $senha = trim($senha);
    
    $senhaConfirmacao = $senhaConfirmacao=mysqli_real_escape_string($_conn,$_POST["senhaConfirmacao"]);
    $senhaConfirmacao = trim($senhaConfirmacao);
    
    
    if (strlen(trim($senha))<8) { 
            $mensagem="A senha tem que ter pelo menos 8 caracteres!";
         
            $podeAlterar = "Nao"; 
    }
        
    if ($senha!=$senhaConfirmacao) { 
            $mensagem="A senha de confirmação deve ser igual à primeira senha!";
          
            $podeAlterar = "Nao"; 
    }
    
    
    if ( $podeAlterar == "Sim") {
        
        ///////////////////////////////////
        // ALTERAR SENHA
      
        $sql= "UPDATE users SET PASSWORD = ?, TOKEN_CODE = ''  WHERE CODIGO = ?";

        if ( $stmt = mysqli_prepare($_conn, $sql)  ) {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "ss", $senhaHash, $codigo);
            
            mysqli_stmt_execute($stmt);
            
           
            $mensagem = "A sua nova senha foi alterada com sucesso." ;
              
            $interfaceSenhas = "Nao";
            
            
            $sucesso = "Sim";
            $geraForm = "Nao";
            
      

        } else{
            
            echo "STATUS ADMIN (nova senha): " . mysqli_error($_conn);
        }

       // mysqli_stmt_close($stmt);
        
    }
    
}
    
?>

<!DOCTYPE html>
<html>
<title>Cloud Gallery - Definir nova senha</title>
<?php include_once  './includes/estilos.php'; ?>
<body>
<?php include_once  './includes/menus.php'; ?>


<div class="w3-container w3-light-grey" style="padding:128px 16px" >
  <h3 class="w3-center">DEFINIR NOVA SENHA</h3>
  
  
  
            <?php if ( $geraForm == "Sim") { ?>
            
            <p class="w3-center w3-large">Introduza a nova senha pretendida</p>
  
            <form action="#" method="POST">

                <br> Alteração de senha para <?php echo $nome;?>.
                
                <?php if ( $interfaceSenhas == "Sim") { ?>
                        
                        <p class="w3-large w3-text-red"><?php echo $mensagem;?></p>
                
                        <p><input class="w3-input w3-border" type="password" placeholder="Nova Senha"  name="senha" value="<?php echo $senha;?>" required></p>
                        <p><input class="w3-input w3-border" type="password" placeholder="Confirmação da nova Senha"  name="senhaConfirmacao" value="<?php echo $senhaConfirmacao;?>" required></p>
                      
                        <br><br> 
                        <button class="w3-button w3-black" name="botao-guardar-nova-senha" type="submit">CONFIRMAR NOVA SENHA</button>
                <?php } else { ?>
                     <p class="w3-large w3-text-red"><?php echo $mensagem;?></p>
               <?php }?>
            </form>
          <?php } else { ?>
          
          <?php 
          $destino = "./home";
          if ( $sucesso == "Nao" ) { 
          		$destino = "./userRecuperarSenha.php";
          }
          
          ?>
          
          <form action="<?php echo $destino;?>" method="POST">
              
              <p class="w3-large w3-text-red"><?php echo $mensagem;?></p> 
              
              <?php if ( $interfaceSenhas == "Nao") { 
              
              	if ( $sucesso == "Nao" ) {
              ?>
                
                <button class="w3-button w3-black" type="submit"> Solicitar recuperação de senha</button>
              <?php } ?>
              
          </form>  
          <?php 
              
              } 
           }
              
              
          ?>
  
 
  <form action="./home" method="POST">
   		<p><button class="w3-button w3-black" type="submit">PÁGINA PRINCIPAL</button></p>
  </form>
  
</div>


<!--  -->
<?php include_once  './includes/rodape.php'; ?>
<?php include_once  './includes/scripts.php'; ?>
</body>
</html>





