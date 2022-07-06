<?php

session_start();

include_once  './connect_DB.php';

// if (!isset($_SESSION["UTILIZADOR"]) ) { 
//     header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
//     header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
//     header("Location: ./home");
// }


// if ($_SESSION["NIVEL_UTILIZADOR"]!=2 ) {
//     header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
//     header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately
//     header("Location: ./home");
// }



// manter o critério de pesquisa

if (isset($_POST["filtroSQL"])) {

  $filtroSQL = $_POST["filtroSQL"];

  if (trim($filtroSQL) == '') {
    $filtroSQL = "SELECT * FROM users ORDER BY CODIGO ASC";
  }
} else {
  $filtroSQL = "SELECT * FROM users ORDER BY CODIGO DESC";
}


// if ( $_SESSION["NIVEL_UTILIZADOR"]==2) {

//     if ( isset($_POST["botao-ordenar-users-nome-asc"])  ) {

//         $filtroSQL = "SELECT * FROM users ORDER BY NOME ASC";
//     }
//     if ( isset($_POST["botao-ordenar-users-nome-desc"])  ) {

//         $filtroSQL = "SELECT * FROM users ORDER BY NOME DESC";
//     }
// }



$campoPesquisa = "";

if (isset($_POST['botao-pesquisar-lista-utilizadores'])) {

  $campoPesquisa = trim(mysqli_real_escape_string($_conn, $_POST['campoPesquisa']));

  if (trim($campoPesquisa) != "") {

    $filtroSQL = "SELECT * FROM users  WHERE (CODIGO LIKE '%$campoPesquisa%') OR (NOME LIKE '%$campoPesquisa%') OR (EMAIL LIKE '%$campoPesquisa%') OR (DATA_HORA LIKE '%$campoPesquisa%') ORDER BY CODIGO;";
  }
}



if (isset($_POST["botao-ativar-utilizador"])) {

  // fazer update à tabela de users para atualizar o estado e limpar o token
  $sql = "UPDATE  users SET USER_STATUS=1, TOKEN_CODE=? WHERE CODIGO=?";

  if ($stmt = mysqli_prepare($_conn, $sql)) {

    $codeAtivar = "";
    $codigoAtivar = $_POST["codigoAtivar"];

    mysqli_stmt_bind_param($stmt, "ss", $codeAtivar, $codigoAtivar);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
  } else {
    mysqli_stmt_close($stmt);
    // falhou a atualização

    echo "STATUS ADMIN (ativar utilizador manualmente): " . mysqli_error($_conn);
  }
}


if (isset($_POST["botao-bloquear-utilizador"])) {

  // fazer update à tabela de users para atualizar o estado e limpar o token
  $sql = "UPDATE  users SET USER_STATUS=2, TOKEN_CODE=? WHERE CODIGO=?";

  if ($stmt = mysqli_prepare($_conn, $sql)) {

    $codeAtivar = "";
    $codigoAtivar = $_POST["codigoAtivar"];

    mysqli_stmt_bind_param($stmt, "ss", $codeAtivar, $codigoAtivar);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
  } else {
    mysqli_stmt_close($stmt);
    // falhou a atualização

    echo "STATUS ADMIN (ativar utilizador manualmente): " . mysqli_error($_conn);
  }
}

if (isset($_POST["botao-desbloquear-utilizador"])) {

  // fazer update à tabela de users para atualizar o estado e limpar o token
  $sql = "UPDATE  users SET USER_STATUS=1, TOKEN_CODE=? WHERE CODIGO=?";

  if ($stmt = mysqli_prepare($_conn, $sql)) {

    $codeAtivar = "";
    $codigoAtivar = $_POST["codigoAtivar"];

    mysqli_stmt_bind_param($stmt, "ss", $codeAtivar, $codigoAtivar);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
  } else {
    mysqli_stmt_close($stmt);
    // falhou a atualização

    echo "STATUS ADMIN (ativar utilizador manualmente): " . mysqli_error($_conn);
  }
}

$mensagemImportarCSV = "";

if (isset($_POST["botao-importar-contactos"])) {

  // Código original em:
  // https://php-legacy-docs.zend.com/manual/php5/en/function.fgetcsv
  // Adaptado por AB

  $row = 1;
  $registosLidos = 0;
  $registosGravados = 0;

  if (($handle = fopen("csvimport/contactos.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
      $num = count($data);
      //echo "<p> $num fields in line $row: <br /></p>\n";
      $row++;

      ///////////////////////////////////////////////////////
      // ignorar a linha 1 pois é o cabeçalho do ficheiro
      if ($row > 1) {

        ++$registosLidos;
        // extrair campos em função da posição

        $importCodigo = trim($data[0]);
        $importEmail = trim($data[1]);
        $importPassword = trim($data[2]);
        $importNome = trim($data[3]);


        // Passo seguinte validar se já existe na BD 

        $stmt = $_conn->prepare('SELECT * FROM users WHERE CODIGO = ?');
        $stmt->bind_param('s', $importCodigo);
        $stmt->execute();

        $resultadousers = $stmt->get_result();

        if ($resultadousers->num_rows > 0) {

          // já existe um utilizador com este código na BD

          $stmt->free_result();
          $stmt->close();
        } else {

          // ok, o utilizador pode ser inserido

          $sql = "INSERT INTO users (CODIGO, EMAIL, PASSWORD, NOME, NIVEL,USER_STATUS, MENSAGENS_MARKETING,DATA_HORA)
                                    VALUES (?,?,?,?,?,?,?,?)";

          if ($stmt = mysqli_prepare($_conn, $sql)) {

            $nivel = 1;
            $status = 1; // o utilizador ficará com a conta ativa de imediato

            $senhaHash = password_hash($importPassword, PASSWORD_DEFAULT);

            $aceitoMarketing = 0; // por omissão novos users não aceitam marketing

            date_default_timezone_set('Europe/Lisbon');
            $data_hora = date("Y-m-d H:i:s", time());

            mysqli_stmt_bind_param($stmt, "ssssiiis", $importCodigo, $importEmail, $senhaHash, $importNome, $nivel, $status, $aceitoMarketing, $data_hora);


            mysqli_stmt_execute($stmt);

            ++$registosGravados;
          } else {
            echo "STATUS ADMIN (importar utilizadores): " . mysqli_error($_conn);
          }

          mysqli_stmt_close($stmt);
        }
      }
      ///////////////////////////////////////
    }
    fclose($handle);
  }
  $mensagemImportarCSV = $registosLidos . " registos lidos, " . $registosGravados . " registos gravados.";
}


if (isset($_POST["botao-exportar-contactos"])) {


  $delimiter = ";";
  $filename = "Utilizadores_registados" . "_" . date('Y-m-d') . ".csv";

  //create a file pointer
  $f = fopen('php://memory', 'w');
  //set column headers
  $fields = array('Nome', 'Email', 'Hora de registo');
  fputcsv($f, $fields, $delimiter);

  $query = $filtroSQL;

  $result = mysqli_query($_conn, $query);
  while ($row = mysqli_fetch_assoc($result)) {

    $nomeCSV = $row["NOME"];
    $nomeCSV = iconv("UTF-8", "ISO-8859-1", $nomeCSV);

    $emailCSV = $row["EMAIL"];

    $lineData = array($nomeCSV, $emailCSV, $row['DATA_HORA']);

    fputcsv($f, $lineData, $delimiter);
  }

  //move back to beginning of file
  fseek($f, 0);

  //set headers to download file rather than displayed
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename="' . $filename . '";');
  //output all remaining data on a file pointer
  fpassthru($f);

  fclose($f);
  exit;
}




// saber total de utilizadores
$resultadoTotal = mysqli_query($_conn, "SELECT COUNT(CODIGO) AS TOTAL FROM users");

$UTILIZADORES_TOTAL = 0;
if (mysqli_num_rows($resultadoTotal) > 0) {
  while ($rowTotal = mysqli_fetch_assoc($resultadoTotal)) {
    $UTILIZADORES_TOTAL = $rowTotal["TOTAL"];
  }
}
mysqli_free_result($resultadoTotal);


?>
<!DOCTYPE html>
<html>
<title>Cloud Gallery - Gerir utilizadores</title>
<?php include_once  './includes/estilos.php'; ?>

<body>
  <?php include_once  './includes/menus.php'; ?>

  <i id="ancoraTopo"></i>

  <div class="w3-container w3-light-grey" style="padding:128px 16px">



    <h3 class="w3-center">GERIR UTILIZADORES</h3>
    <p class="w3-center w3-large">Zona exclusiva para o(a) administrador(a).</p>



    <form action="./userGerirUtilizadores.php#ancoraTopo" method="POST">
      <p class="w3-center w3-large"><B><?php echo $UTILIZADORES_TOTAL; ?> utilizador(es) na base de dados.</B><BR>
        <button class="w3-button w3-black" type="submit" name="botao-refresh-users-asc"> <i class="material-icons" style="font-size:24px;vertical-align:middle;">autorenew</i> ATUALIZAR</button>
        <button class="w3-button w3-black" type="submit" name="botao-exportar-contactos"> <i class="material-icons" style="font-size:24px;vertical-align:middle;">file_download</i> EXPORTAR CSV</button>
        <button class="w3-button w3-black" type="submit" name="botao-importar-contactos"> <i class="material-icons" style="font-size:24px;vertical-align:middle;">file_upload</i> IMPORTAR CSV</button>
      <p class="w3-center w3-large"><b><?php echo $mensagemImportarCSV; ?></b></p>
      </p>
      <input id="filtroSQL" name="filtroSQL" type="hidden" value="<?php echo $filtroSQL; ?>">
    </form>


    <form action="./userGerirUtilizadores.php#ancoraTopo" method="POST">
      <p><input class="w3-input w3-border" type="text" placeholder="Pesquisar código, nome, e-mail ou data/hora" name="campoPesquisa" value="<?php echo $campoPesquisa; ?>"></p>
      <p> <button class="w3-button w3-black" name="botao-pesquisar-lista-utilizadores" type="submit"> <i class="material-icons" style="font-size:24px;vertical-align:middle;">search</i> PESQUISAR</button></p>
    </form>

    <i id="ancoraTopo"><br><br></i>

    <i id="ancoraUtilizador0"></i>

    <p>

    <table style="width:100%">
      <tr class="w3-black">
        <th>Código</th>
        <th>Situação</th>
        <th>Nome<br>

          <form action="./userGerirUtilizadores.php#ancoraTopo" method="POST">
            <i class="material-icons" style="font-size:24px;vertical-align:middle;">sort_by_alpha</i><BR>
            <button type="submit" name="botao-ordenar-users-nome-asc" class="w3-button"><i class="material-icons" style="font-size:24px;vertical-align:middle;">arrow_drop_up</i></button>
            <button type="submit" name="botao-ordenar-users-nome-desc" class="w3-button"><i class="material-icons" style="font-size:24px;vertical-align:middle;">arrow_drop_down</i></button>

          </form>


        </th>
        <th>Email</th>
        <th>Data de registo</th>
      </tr>


      <?php

      $resultadoTabela = mysqli_query($_conn, $filtroSQL);

      if (mysqli_num_rows($resultadoTabela) > 0) {
        $ctd = 0;
        while ($rowTabela = mysqli_fetch_assoc($resultadoTabela)) {
          $ctd = $ctd + 1;
      ?>

          <tr>

            <td id="ancoraUtilizador<?php echo $ctd; ?>"><b><?php echo $rowTabela["CODIGO"] ?></b></td>

            <td>

              <?php if ($rowTabela["USER_STATUS"] == 0) { ?><i class="material-icons w3-text-red" style="font-size:24px;vertical-align:middle;">person</i><?php } ?>
              <?php if ($rowTabela["USER_STATUS"] == 1) { ?><i class="material-icons w3-text-green" style="font-size:24px;vertical-align:middle;">how_to_reg</i><?php } ?>
              <?php if ($rowTabela["USER_STATUS"] == 2) { ?><i class="material-icons w3-text-red" style="font-size:24px;vertical-align:middle;">voice_over_off</i><?php } ?>

              <?php if ($rowTabela["MENSAGENS_MARKETING"] == 0) { ?><i class="material-icons w3-text-red" style="font-size:24px;vertical-align:middle;">notifications_off</i><?php } ?>

              <?php if ($rowTabela["USER_STATUS"] == 0) { ?>
                <form action="./userGerirUtilizadores.php#ancoraUtilizador<?php echo ($ctd - 1); ?>" method="POST">
                  <i class="material-icons w3-text-green" style="font-size:24px;vertical-align:middle;">subdirectory_arrow_right</i>
                  <button type="submit" name="botao-ativar-utilizador" class="w3-button w3-text-green"><i class="material-icons" style="font-size:24px;vertical-align:middle;">how_to_reg</i></button>
                  <input id="codigoAtivar" name="codigoAtivar" type="hidden" value="<?php echo $rowTabela["CODIGO"]; ?>">

                  <input id="filtroSQL" name="filtroSQL" type="hidden" value="<?php echo $filtroSQL; ?>">
                </form>

              <?php } ?>

              <?php if ($rowTabela["USER_STATUS"] == 1) { ?>
                <form action="./userGerirUtilizadores.php#ancoraUtilizador<?php echo ($ctd - 1); ?>" method="POST">
                  <i class="material-icons w3-text-grey" style="font-size:24px;vertical-align:middle;">subdirectory_arrow_right</i>
                  <button type="submit" name="botao-bloquear-utilizador" class="w3-button w3-text-grey"><i class="material-icons" style="font-size:24px;vertical-align:middle;">voice_over_off</i></button>
                  <input id="codigoAtivar" name="codigoAtivar" type="hidden" value="<?php echo $rowTabela["CODIGO"]; ?>">

                  <input id="filtroSQL" name="filtroSQL" type="hidden" value="<?php echo $filtroSQL; ?>">
                </form>
              <?php } ?>

              <?php if ($rowTabela["USER_STATUS"] == 2) { ?>
                <form action="./userGerirUtilizadores.php#ancoraUtilizador<?php echo ($ctd - 1); ?>" method="POST">
                  <i class="material-icons w3-text-grey" style="font-size:24px;vertical-align:middle;">subdirectory_arrow_right</i>
                  <button type="submit" name="botao-desbloquear-utilizador" class="w3-button w3-text-grey"><i class="material-icons" style="font-size:24px;vertical-align:middle;">how_to_reg</i></button>
                  <input id="codigoAtivar" name="codigoAtivar" type="hidden" value="<?php echo $rowTabela["CODIGO"]; ?>">

                  <input id="filtroSQL" name="filtroSQL" type="hidden" value="<?php echo $filtroSQL; ?>">
                </form>
              <?php } ?>



            </td>

            <td><b> <?php echo $rowTabela["NOME"] ?></b><?php if ($rowTabela["NIVEL"] == 2) {
                                                          echo "<br>(Administrador)";
                                                        } ?></td>
            <td><?php echo $rowTabela["EMAIL"] ?></td>
            <td>[<?php echo $rowTabela["DATA_HORA"] ?>]</td>


          </tr>

      <?php
        }
      }
      mysqli_free_result($resultadoTabela);

      ?>
    </table>




  </div>

  <?php include_once  './includes/zonaprivada.php'; ?>
  <!--  -->
  <?php include_once  './includes/rodape.php'; ?>
  <?php include_once  './includes/scripts.php'; ?>
</body>

</html>