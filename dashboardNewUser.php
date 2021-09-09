<?php
  session_start();
  ob_start();
  
  //Recupera os valores da tabela user atribui as variaveis
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];

    require("actions/connection.php");

    }else{
      echo "<script>window.location = '../php_helper/index.html'</script>";
    }  
?>
<!-- Permite o acesso apenas para utilizadores com o perfil administrador -->
<?php if($admin): ?>
  <!DOCTYPE html>
  <html lang="pt-br">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>PHP HELPER</title>
      <link rel="stylesheet" type="text/css" href="style/dashboardNewUser.css">
      <script type="text/javascript" src="script/jquery.js"></script>
      <script type="text/javascript" src="script/access.js"></script>
      <script type="text/javascript" src="script/scripts.js"></script>
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
            <input type="password" name="keyword" id="keyword" id="password" minlength="8" maxlength="12" placeholder="Inserir Senha" autocomplete="off" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onKeyUp="verifyStrongKeyword();"/>
            <br/><span id="keywordStatus"></span>
            <label for="admin">Tipo de Perfil</label>
            <input list="admin" name="admin" placeholder="Escolha o perfil de utilizador" autocomplete="off" required="required">
            <datalist id="admin">
              <option value="Administrador">
              <option value="Utilizador">
              <option value="Manutenção">
            </datalist>
          </div>
          <div id="button">
            <button id="btnInsertUser">Inserir</button>
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