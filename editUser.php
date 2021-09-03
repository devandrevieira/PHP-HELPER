<?php
  session_start();
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];
    require("actions/connection.php");

    $id = $_GET['id'];
    $query = $connection->prepare("SELECT * FROM user WHERE id = $id");
    $query->execute();
    $row=$query->fetch();
  }else{
    echo "<script>window.location = '../php_helper/index.html'</script>";
  }  
?>
<?php if($admin): ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>PHP HELPER</title>
    <link rel="stylesheet" type="text/css" href="style/dashboardNewUser.css">
    <script type="text/javascript" src="script/jquery.js"></script>
    <script type="text/javascript" src="script/access.js"></script>
  </head>
  <body>
    <header>
      <div id="content">
        <div id="user">
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
        <div id="logout">
        <a href="actions/logout.php"><button>Logout</button></a>
        </div>
      </div>
    </header>
    
    <div id=form>
      <form id="newUser" method="POST" action="actions/updateUser.php?id=<?=$row["id"] ?>">
        <span class="title">editar dados do utilizador</span>
        <div id="line">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" value="<?php echo $row["name"]; ?>" autocomplete="off" required="required">
        <label for="name">E-mail</label>
        <input type="email" name="email" id="email" value="<?php echo $row["email"]; ?>" autocomplete="off" required="required">
        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" id="telefone" value="<?php echo $row["telefone"]; ?>" autocomplete="off" required="required">
        <label for="keyword">Senha</label>
        <input type="text" name="keyword" id="keyword" value="<?php echo $row["keyword"]; ?>" autocomplete="off" required="required">
        <label for="admin">Tipo de Perfil</label>
        <input list="admin" name="admin" value="<?php
        if($row["admin"] = 1){
          echo "Administrador";
        }elseif($row["admin"] = 0){
          echo "Utilizador";    
        }else{
          echo "Manutenção";  
        }
          ?>" onfocus="this.value='';" autocomplete="off" required="required">
        <datalist id="admin">
          <option value="Administrador">
          <option value="Utilizador">
          <option value="Manutenção">
        </datalist>
        </div>
        <div id="button">
          <button id="btnInsertUser">Atualizar</button>
        </div>
      </form>
      <div id="btnCancel">
      <a href="managerUser.php"><button id="btnCancel">Cancelar</button></a>
      </div>
    </div>
  </body>
  </html>
  <?php else: echo "<script>window.location = '../php_helper/dashboard.php'</script>"; ?> 
<?php endif; ?>