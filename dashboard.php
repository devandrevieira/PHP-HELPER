<?php
  session_start();
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];
    require_once("actions/connection.php");
  }else{
    echo "<script>window.location = '../php_helper/index.html'</script>";
  }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PHP HELPER</title>
  <link rel="stylesheet" type="text/css" href="style/dashboard.css">
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
    <form id="menuOption">
      <span class="title">ESCOLHA UMA OPÇÃO</span>
      <div id="button">
        <button id="btnLogin" onclick="window.location.href='dashboardNewCall.php';">NOVO CHAMADO</button>
      </div>
      <div id="button">
        <button id="btnLogin" onclick="window.location.href='consultCall.php';">CONSULTAR CHAMADO</button>
      </div>
      <?php if($admin!=1):?>
      <div id="button">
      <button id="btnLogin">CONTATAR HELPDESK</button>
      </div>
      <?php endif; ?>
      <?php if($admin==1): ?>
      <div id="button">
      <button id="btnLogin" onclick="window.location.href='managerUser.php';">GERENCIAR UTILIZADORES</button>
      </div>
      <?php endif; ?>
      <div id="logo">
        <img src="style/img/logo.svg" alt="" width="120">
      </div>
    </form>
  </div>
</body>
</html>