<?php

  ini_set('display_errors', 'off');
  session_start();

  //Recupera os valores da tabela user atribui as variaveis  
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];

    require("actions/connection.php");
    
    }else{
      echo "<script>window.location = '../php_helper/index.html'</script>";
    }  
?>

  <!DOCTYPE html>
    <html lang="pt-br">
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="style/consultCall.css"> 
        <title>PHP HELPER</title>
      </head>
      <body>
        <header>
          <div id="content">
            <div id="user">
              <!-- Exibe informações de acordo com perfil de usuário -->
              <span>
                <?php if($admin==1){
                  echo "Administrador - ".$name;
                }elseif($admin==0){
                  echo "Utilizador - ".$name;
                }else{
                  echo "Manutenção - ".$name;
                } ?>
              </span>
            </div>
            <div id="logo">
              <span class="logo">PHP HELPER</span>
            </div>
            <div id="return">
            <a href="dashboard.php"><button>Voltar</button></a>
            </div>
            <div id="logout">
            <a href="actions/logout.php"><button>Logout</button></a>
            </div>
          </div>
        </header>
        <div id="content">
          <div id="nameScreen">
            <span class="title">Lista de Chamados</span>
          </div>
          <div id="message">
          <?php
          if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
          }
          ?>
          </div>
          
          <div id="userTable">
            <div id="searchUser">
              <div id="form">
                <form action="consultCall.php" method="GET">
                    <input type="text" class="form-control" name="keySearch" placeholder="Filtrar Chamados">
                    <input type="submit" class="searchButton" name="searchButton" action="consultCall.php" value="Filtrar" >
                </form>
              </div>
              <div id="newCall">
                <a href="dashboardNewCall.php"><input type="submit" class="newUserButton" name="newUserButton" action="consultCall.php" value="Novo Chamado"></a>
              </div>
            </div>
            <table>
              <thead>
                <tr>
                  <td>ID CHAMADO</td>
                  <td>ID USER</td>
                  <td>NOME</td>
                  <td>EMAIL</td>
                  <td>TELEFONE</td>
                  <td>TIPO</td>
                  <td>LOCAL</td>
                  <td>QUARTO</td>
                  <td>DATA</td>
                  <td>DESCRIÇÃO</td>
                  <td>STATUS</td>
                  <td>VER</td>
                  <?php if($admin!=0): ?>
                  <td>ALTERAR STATUS</td>
                  <?php endif ?>
                </tr>
              </thead>
              <tbody>
                <?php
                
                //Paginação
                $currentPage = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
                $page = (!empty($currentPage)) ? $currentPage : 1;

                $resultLimit = 8;

                $start = ($resultLimit * $page) - $resultLimit;
                
                  //Função de filtragem de informações
                  if(isset($_GET["searchButton"])){
                  }
                    $keySearch=$_GET['keySearch'];         
                    $query = $connection->prepare("SELECT * FROM calltable WHERE idCall ='$keySearch' or idUserCall = '$keySearch' or nameCall = '$keySearch' or emailCall = '$keySearch' or typeCall LIKE '%$keySearch%' or local LIKE '%$keySearch%' or room = '$keySearch' or dateCall = '$keySearch' or status = '$keySearch' ORDER BY idCall LIMIT $start, $resultLimit");
                    
                    $query->execute();

                    while ($row=$query->fetch()) {?>
                    <tr class="lines">
                      <td><?php echo $row["idCall"]; ?></td>
                      <td><?php echo $row["idUserCall"]; ?></td>
                      <td><?php echo $row["nameCall"]; ?></td>
                      <td><?php echo $row["emailCall"]; ?></td>
                      <td><?php echo $row["telefoneCall"]; ?></td>
                      <td><?php echo $row["typeCall"]; ?></td>
                      <td><?php echo $row["local"]; ?></td>
                      <td><?php echo $row["room"]; ?></td>
                      <td><?php echo $row["dateCall"]; ?></td>
                      <td><?php echo $row["description"]; ?></td>     
                      <td><?php echo $row["status"]; ?></td>
                      <td class="align-middle"><a href= "viewCall.php?idCall=<?=$row["idCall"] ?>"><img src="style/img/see.svg" alt="Ver" width="25"></a></td>
                      <?php if($admin!=0): ?>
                      <td class="align-middle"><a href= "editCall.php?idCall=<?=$row["idCall"] ?>"><img src="style/img/edit.svg" alt="Editar" width="25"></a></td>
                  <?php endif ?>               
                  </tr>
                <?php } ?>
              </tbody>
            </table>              
          </div>
          <div id="pagination">
          
          <?php

            //Paginação
            $numberOfRegister = "SELECT COUNT(idCall) AS numResult FROM calltable";
            $resultNumberOfRegister = $connection -> prepare($numberOfRegister);
            $resultNumberOfRegister -> execute();
            $rowNumberOfRegister = $resultNumberOfRegister -> fetch(PDO::FETCH_ASSOC);
            $totalPage = ceil($rowNumberOfRegister['numResult'] / $resultLimit);
            $maxLink = 2;

            echo "<a href='consultCall.php?page=1'>Primeira</a>";
            
            for($previousPage = $page - $maxLink; $previousPage <= $page - 1; $previousPage++ ){
              if($previousPage >= 1){
              echo "<a href='consultCall.php?page=$previousPage'>$previousPage</a>";
              }
            } 
            
            echo "<a href='#'>$page</a>";

            for($nextPage = $page + 1; $nextPage <= $page + $maxLink; $nextPage++ ){
              if($nextPage <= $totalPage){
              echo "<a href='consultCall.php?page=$nextPage'>$nextPage</a>";
              }
            }

            echo "<a href='consultCall.php?page=$totalPage'>Última</a>";
          
          ?>
          </div>
        </div>
      </body>
  </html>