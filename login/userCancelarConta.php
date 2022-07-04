<?php 

session_start();

include_once  './conexaobasedados.php'; 


include_once './function_mail_utf8.php'; 


$msgTemporaria = "";

$mensagemErroMotivo = "";
$mensagemErroSenha = "";
$nome = "";
$email = "";


if ( !isset($_SESSION["UTILIZADOR"])) {
     header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
     header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
     header("Location: home");
} else {
    // ler definições de conta 
    
    $codigo = $_SESSION["UTILIZADOR"]; 

    $stmt = $_conn->prepare('SELECT * FROM users WHERE CODIGO = ?');
    $stmt->bind_param('s', $codigo); 
    $stmt->execute();

    $resultadousers = $stmt->get_result();
    
    if ($resultadousers->num_rows > 0) {
        while ($rowusers = $resultadousers->fetch_assoc()) {
         
            
            $senha ="";
            $senhaEncriptada =$rowusers['PASSWORD'];
            
            $nome = $rowusers['NOME'];
            
            if ( !isset($_POST["motivo"])) {
                
                // ok
                
                   
            } else {
                
                $podeApagar = "Sim"; 
                
                ///////// em modo de eliminação - filtrar e validar campos
                
                $motivo= mysqli_real_escape_string($_conn, $_POST['motivo']);
                $motivo = trim($motivo); 


                if (strlen(trim($motivo))<10) {
                     $mensagemErroMotivo="Utilize pelo menos 10 caracteres para nos indicar o seu motivo.";
                     $podeApagar = "Nao"; 
                }
                ///////////////////////////////  
            }
            
            
            
            
        }
    } else {
        echo "STATUS ADMIN (cancelar conta): " . mysqli_error($_conn);
    }           
                    
    
     mysqli_stmt_close($stmt);
    
}









if ( isset($_POST['botao-apagar-conta']) ) {
        
        // verificar senha por questões de segurança
        $senha=mysqli_real_escape_string($_conn, $_POST['senha']);
        $senha = trim($senha);
        
        if ( password_verify($senha, $senhaEncriptada)) {
            
            // senha OK, filtar e validar inputs
        } else {
            
            $mensagemErroSenha = "Senha incorreta!";
            $podeApagar = "Nao"; 
        }
        
        
        if ( $podeApagar == "Sim" )  {
            
           
                ///////////////////////////////////
                // APAGAR
                //////////////////////////////////
            
                // Tabela users
            
                $sql= "DELETE FROM users WHERE CODIGO = ?";
                
                if ( $stmt = mysqli_prepare($_conn, $sql) ) {
                
                    mysqli_stmt_bind_param($stmt, "s", $codigo);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    
                } else{
                
                    echo "STATUS ADMIN (cancelar conta - utilizador): " . mysqli_error($_conn);
                }
               
                
                // REMOVER PASTA DAS IMAGENS DO UTILIZADOR
                $pasta = "./uploadimagens/";
                $pastaPublicacao = trim($_SESSION["UTILIZADOR"]);
                $pasta = $pasta . $pastaPublicacao;
                
                deleteDirectory($pasta);
                
                // ENVIAR MOTIVO POR MAIL ao utilizador
               

                $urlPagina = "http://localhost:8888/";
                
                $email =  $_SESSION["EMAIL_UTILIZADOR"];
                
                $mensagem = "$nome cancelou a sua conta" . "." . "\r\n" .  "\r\n" .

                    "E-mail: $email". "\r\n" .  "\r\n" .

                    "Registámos o motivo: $motivo" ."\r\n" ."\r\n" .

                    "Esta mensagem foi-lhe enviada automaticamente.";  

                $subject = "$nome cancelou conta em $urlPagina";

                // use wordwrap() if lines are longer than 70 characters
                $mensagem = wordwrap($mensagem,70);

                // send email
                mail_utf8($email,$subject,$mensagem); 
                  
                
                
                ////////////////////////////
               
                $msgTemporaria = "A sua conta foi cancelada. Todos os seus dados foram removidos da nossa base de dados.";
                    
                // limpar variáveis de sessão
                session_destroy();

                // encaminhar com timer 5 segundos
                header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
                header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
                header("Refresh: 5; URL=home"); 
             
                
        }
            
            
}


function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
        
    }
    
    return rmdir($dir);
}

 
?>

<!DOCTYPE html>
<html>
<title>Cloud Gallery - Cancelar conta</title>
<?php include_once  './includes/estilos.php'; ?>
<body>
<?php include_once  './includes/menus.php'; ?>


<div class="w3-container w3-light-grey" style="padding:128px 16px">
  <h3 class="w3-center">CANCELAR CONTA</h3>
  <p class="w3-center w3-large">Cancelar a sua conta de utilizador.</p>
  
  
  <p class="w3-center w3-large"><b><?php echo $msgTemporaria;?></b></p>

  <form action="#" method="POST">
  
         <p class="w3-center w3-large">
            Esta opção permite cancelar a sua conta. 
            Os seus dados pessoais serão removidos definitivamente da nossa base de dados. 
            De acordo com os nossos princípios éticos de responsabilidade e transparência descritos na nossa política de privacidade,
            esta remoção inclui também dados referentes a atividades em que tenha participado nesta página. 
            Esta operação é irreversível.<br><br>Por favor, indique-nos apenas o motivo pelo qual pretende cancelar a sua conta.
            Será também enviado em email para <b><?php echo $_SESSION["EMAIL_UTILIZADOR"];?></b>
         </p>
  
         <p><input class="w3-input w3-border" type="text" placeholder="Motivo"  name="motivo" value="<?php echo $motivo;?>" required></p>
         <p class="w3-large w3-text-red"><?php echo $mensagemErroMotivo;?></p>
       
         <p class="w3-center w3-large">Utilizador <b><?php echo $codigo;?></b>, serão removidos todos os seus dados, por favor digite a sua senha para cancelar a conta.</p>
       
         
         <p><input class="w3-input w3-border" type="password" placeholder="Senha"  name="senha" value="<?php echo $senha;?>" required></p>
         <p class="w3-large w3-text-red"><?php echo $mensagemErroSenha;?></p>
         
         
        
   		 <p><button class="w3-button w3-black" type="submit" name="botao-apagar-conta">Cancelar conta imediatamente</button></p>
   
  </form>
  
  <br>
    
  <form action="./home" method="POST">
        
         <button class="w3-button w3-black" name="botao-desistir-apagar" type="submit"> Não pretendo cancelar a minha conta</button>
       
  </form>
  
  
  
</div>


<!--  -->
<?php include_once  './includes/rodape.php'; ?>
<?php include_once  './includes/scripts.php'; ?>
</body>
</html>
