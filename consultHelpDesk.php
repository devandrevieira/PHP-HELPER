<?php

  ini_set('display_errors', 'off');
  session_start();

  //Recupera os valores da tabela user atribui as variaveis
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];

    require("actions/connection.php");

    }else{
      header("Location: ../dashboard.php");
      $_SESSION['msg'] = "<p>Erro de conexão!.</p>";
    }  
?>
  <!-- Perrmite o acesso apenas para utilizadores com perfil Administrador -->
  <?php if($admin): ?>
    <!DOCTYPE html>
    <html lang="pt-br">
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="style/managerUser.css"> 
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
        
        <div id="message">
          <?php
          if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
          }
          ?>
        </div>
        
        <div id="content">
          <div id="nameScreen">
            <span class="title">LISTA DE HELPDESKS</span>
          </div>
                    
          <div id="userTable">
            <div id="searchUser">
              <div id="form">
                <form action="consultHelpDesk.php" method="GET">
                    <input type="text" class="form-control" name="keySearch" placeholder="Filtrar Utilizador">
                    <input type="submit" class="searchButton" name="searchButton" action="consultHelpDesk.php" value="Filtrar" >
                </form>
              </div>
              <div id="newUser">
                <a href="dashboardNewUser.php"><input type="submit" class="newUserButton" name="newUserButton" action="managerUser.php" value="Novo Utilizador"></a>
              </div>
            </div>
            <table>
              <thead>
                <tr>
                  <td>ID HELP</td>
                  <td>ID</td>
                  <td>NOME</td>
                  <td>EMAIL</td>
                  <td>TELEFONE</td>
                  <td>DESCRIÇÃO</td>
                  <td>STATUS</td>
                  <td>ALTERAR STATUS</td>
                </tr>
              </thead>
              <tbody>
                <?php

                //Paginação
                $currentPage = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
                $page = (!empty($currentPage)) ? $currentPage : 1;

                $resultLimit = 8;

                $start = ($resultLimit * $page) - $resultLimit;

                  if (isset($_GET["searchButton"])){
                  }
                      $keySearch=$_GET['keySearch'];         
                      $query = $connection->prepare("SELECT * FROM helpdesk WHERE idHelp ='$keySearch' or nameHelp LIKE '%$keySearch%' or emailHelp LIKE '%$keySearch%' LIMIT $start, $resultLimit");
                      $query->execute();

                    while ($row=$query->fetch()) {?>
                    <tr>
                        <td><?php echo $row["idHelp"]; ?></td>
                        <td><?php echo $row["idUserHelp"]; ?></td>
                        <td><?php echo $row["nameHelp"]; ?></td>
                        <td><?php echo $row["emailHelp"]; ?></td>
                        <td><?php echo $row["telefoneHelp"]; ?></td>
                        <td><?php echo $row["descriptionHelp"]; ?></td>
                        <td><?php echo $row["statusHelp"]; ?></td>
                        <td class="align-middle"><a href= "editHelpDesk.php?idHelp=<?=$row["idHelp"] ?>"><img src="style/img/edit.svg" alt="Alterar" width="25"></a></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>              
          </div>
          <div id="pagination">

            <?php
              
              $numberOfRegister = "SELECT COUNT(idHelp) AS numResult FROM helpdesk";
              $resultNumberOfRegister = $connection -> prepare($numberOfRegister);
              $resultNumberOfRegister -> execute();
              $rowNumberOfRegister = $resultNumberOfRegister -> fetch(PDO::FETCH_ASSOC);
              $totalPage = ceil($rowNumberOfRegister['numResult'] / $resultLimit);
              $maxLink = 2;

              echo "<a href='consultHelpDesk.php?page=1'>Primeira</a>";
              
              for($previousPage = $page - $maxLink; $previousPage <= $page - 1; $previousPage++ ){
                if($previousPage >= 1){
                echo "<a href='consultHelpDesk.php?page=$previousPage'>$previousPage</a>";
                }
              } 
              
              echo "<a href='#'>$page</a>";

              for($nextPage = $page + 1; $nextPage <= $page + $maxLink; $nextPage++ ){
                if($nextPage <= $totalPage){
                echo "<a href='consultHelpDesk.php?page=$nextPage'>$nextPage</a>";
                }
              }

              echo "<a href='consultHelpDesk.php?page=$totalPage'>Última</a>";
            
            ?>
          </div>
        </div>
      </body>
    </html>
  <?php else: echo "<script>window.location = '../php_helper/dashboard.php'</script>"; ?> 
  <?php endif; ?>