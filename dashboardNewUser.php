<?php
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
    <title>PHP HELPER</title>
    <link rel="stylesheet" type="text/css" href="style/dashboardNewUser.css">
    <script type="text/javascript" src="script/jquery.js"></script>
    <script type="text/javascript" src="script/access.js"></script>
  </head>
  <body>
    <header>
      <div id="content">
        <div id="user">
          <span><?php echo $admin ? "Administrador - ".$name : "Utilizador - ".$name; ?></span>
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
      <form id="newUser" method="POST" action="actions/insertUser.php">
        <span class="title">inserir dados do utilizador</span>
        <div id="line">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" placeholder="Inserir nome" autocomplete="off" required="required">
        <label for="name">E-mail</label>
        <input type="email" name="email" id="email" placeholder="exemplo@exemplo.com" autocomplete="off" required="required">
        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" id="telefone" placeholder="Inserir Telefone" autocomplete="off" required="required">
        <label for="keyword">Senha</label>
        <input type="text" name="keyword" id="keyword" placeholder="Inserir Senha" autocomplete="off" required="required">
        <label for="admin">Administrador</label>
        <input list="admin" name="admin" placeholder="Administrador? Sim ou Não" autocomplete="off" required="required">
        <datalist id="admin">
          <option value="0">
          <option value="1">
        </datalist>
        </div>
        <div id="button">
          <button id="btnInsertUser">Inserir</button>
        </div>
      </form>
      <div id="button">
      <a href="managerUser.php"><button id="btnCancel">Cancelar</button></a>
      </div>
    </div>
  </body>
  </html>
  <?php else: echo "<script>window.location = '../php_helper/dashboard.php'</script>"; ?> 
<?php endif; ?>