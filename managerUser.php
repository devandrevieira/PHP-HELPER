<?php
  ini_set('display_errors', 'off');
  session_start();
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];
    require("actions/connection.php");
  }else{
    echo "<script>window.location = '../php_helper/index.html'</script>";
  }  
?>
  <?php if($admin): ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="style/managerUser.css"> 
      <title>Gerir Utilizadores - <?php echo $name; ?></title>
    </head>
    <body>
      <header>
        <div id="content">
          <div id="user">
            <span><?php echo $admin ? "Administrador - ".$name : "Usuário - ".$name; ?></span>
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
          <span class="title">Gerenciamento de Utilizadores</span>
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
              <form action="managerUser.php" method="POST">
                  <input type="text" class="form-control" name="keySearch" placeholder="Encontrar Utilizador">
                  <input type="submit" class="searchButton" name="searchButton" action="managerUser.php" value="Procurar" >
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
                <td>ADMIN</td>
                <td>EDITAR</td>
                <td>EXCLUIR</td>
              </tr>
            </thead>
            <tbody>
              <?php
                if (isset($_GET["searchButton"])){
                }
                    $keySearch=$_GET['keySearch'];         
                    $query = $connection->prepare("SELECT * FROM user WHERE id ='$keySearch' or name LIKE '%$keySearch%' or email LIKE '%$keySearch%'");
                    $query->execute();

                while ($row=$query->fetch()) {?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["telefone"]; ?></td>
                    <td><?php echo $row["keyword"]; ?></td>
                    <td><?php echo $row["admin"] ? "SIM" : "NÃO"; ?></td>
                    <td class="align-middle"><a href= "editUser.php?id=<?=$row["id"] ?>"><img src="style/img/edit.svg" alt="Editar" width="25"></a></td>
                    <td class="align-middle"><a href="actions/deleteUser.php?id=<?=$row["id"] ?>" onclick="return confirm('DESEJA REALMENTE EXCLUIR ESSE UTILIZADOR ?')"><img src="style/img/delete.svg" alt="Excluir" width="20"></a></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>              
        </div>
      </div>
    </body>
    </html>
  <?php else: echo "<script>window.location = '../php_helper/dashboard.php'</script>"; ?> 
<?php endif; ?>