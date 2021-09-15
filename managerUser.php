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
            <span class="title">Gerenciamento de Utilizadores</span>
          </div>
                    
          <div id="userTable">
            <div id="searchUser">
              <div id="form">
                <form action="managerUser.php" method="GET">
                    <input type="text" class="form-control" name="keySearch" placeholder="Filtrar Utilizador">
                    <input type="submit" class="searchButton" name="searchButton" action="managerUser.php" value="Filtrar" >
                </form>
              </div>
              <div id="newUser">
                <a href="dashboardNewUser.php"><input type="submit" class="newUserButton" name="newUserButton" action="managerUser.php" value="Novo Utilizador"></a>
              </div>
            </div>
            <table>
              <thead>
                <tr>
                  <td>ID</td>
                  <td>NOME</td>
                  <td>EMAIL</td>
                  <td>TELEFONE</td>
                  <td>SENHA</td>
                  <td>PERFIL</td>
                  <td>EDITAR</td>
                  <td>EXCLUIR</td>
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
                      if($keySearch=='Administrador'){
                        $keySearch=1;
                      }elseif($keySearch=='Utilizador'){
                        $keySearch=0;
                      }elseif($keySearch=='Manutenção'){
                        $keySearch=2;
                      }; 

                      $query = $connection->prepare("SELECT * FROM user WHERE id ='$keySearch' or name LIKE '%$keySearch%' or email LIKE '$keySearch' or admin LIKE '%$keySearch%' LIMIT $start, $resultLimit");
                      $query->execute();

                    while ($row=$query->fetch()) {?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["telefone"]; ?></td>
                        <td><?php echo $row["keyword"]; ?></td>
                        <td><?php if($row["admin"] == 0){
                          echo "Utilizador";
                          }elseif($row["admin"] == 1){
                            echo "Administrador";
                          }else{
                            echo "Manunteção";
                          };?></td>
                        <td class="align-middle"><a href= "editUser.php?id=<?=$row["id"] ?>"><img src="style/img/edit.svg" alt="Editar" width="25"></a></td>
                        <td class="align-middle"><a href="actions/deleteUser.php?id=<?=$row["id"] ?>" onclick="return confirm('DESEJA REALMENTE EXCLUIR ESSE UTILIZADOR ?')"><img src="style/img/delete.svg" alt="Excluir" width="20"></a></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>              
          </div>
          <div id="pagination">

            <?php
              
              $numberOfRegister = "SELECT COUNT(id) AS numResult FROM user";
              $resultNumberOfRegister = $connection -> prepare($numberOfRegister);
              $resultNumberOfRegister -> execute();
              $rowNumberOfRegister = $resultNumberOfRegister -> fetch(PDO::FETCH_ASSOC);
              $totalPage = ceil($rowNumberOfRegister['numResult'] / $resultLimit);
              $maxLink = 2;

              echo "<a href='managerUser.php?page=1'>Primeira</a>";
              
              for($previousPage = $page - $maxLink; $previousPage <= $page - 1; $previousPage++ ){
                if($previousPage >= 1){
                echo "<a href='managerUser.php?page=$previousPage'>$previousPage</a>";
                }
              } 
              
              echo "<a href='#'>$page</a>";

              for($nextPage = $page + 1; $nextPage <= $page + $maxLink; $nextPage++ ){
                if($nextPage <= $totalPage){
                echo "<a href='managerUser.php?page=$nextPage'>$nextPage</a>";
                }
              }

              echo "<a href='managerUser.php?page=$totalPage'>Última</a>";
            
            ?>
          </div>
        </div>
      </body>
    </html>
  <?php else: echo "<script>window.location = '../php_helper/dashboard.php'</script>"; ?> 
  <?php endif; ?>