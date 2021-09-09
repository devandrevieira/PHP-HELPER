<?php

  session_start();

  //Recupera os valores da tabela user atribui as variaveis
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];
    $email = $_SESSION["user"][2];
    $telefone = $_SESSION["user"][3];
    $id = $_SESSION["user"][4];

    require("actions/connection.php");

    }else{
      header("Location: ../dashboard.php");
      $_SESSION['msg'] = "<p>Erro de conexão!.</p>";
    }
?>
  <!DOCTYPE html>
    <html lang="pt-br">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>PHP HELPER</title>
      <link rel="stylesheet" type="text/css" href="style/newHelpDesk.css">
      <script type="text/javascript" src="script/jquery.js"></script>
      <script type="text/javascript" src="script/access.js"></script>
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
        <form id="newUser" method="POST" action="actions/insertHelpDesk.php">
          <span class="title">SOLICITAR HELPDESK</span>
          <div id="line">
            <label for="idUserHelp">ID</label>
            <input type="text" name="idUserHelp" id="idUserHelp" value="<?php echo $id; ?>" autocomplete="off" required="required" readonly>
            <label for="nameHelp">Nome</label>
            <input type="text" name="nameHelp" id="nameHelp" value="<?php echo $name; ?>" autocomplete="off" required="required" readonly>
            <label for="emailHelp">E-mail</label>
            <input type="emailHelp" name="emailHelp" id="email" value="<?php echo $email; ?>" autocomplete="off" required="required" readonly>
            <label for="telefoneHelp">Telefone</label>
            <input type="text" name="telefoneHelp" id="telefoneHelp" value="<?php echo $telefone;?>" autocomplete="off" required="required" readonly>
          </div>
          <div id="lineText" style="display:inline-block;">
            <label for="descriptionHelp">Solicitação / Problema</label>
            <textarea name="descriptionHelp" id="descriptionHelp" placeholder="Reporte o problema aqui..." maxlength="2000" autocomplete="off" required="required"></textarea>
          </div>
          <div id="button">
            <button id="btnInsertUser">ENVIAR</button>
          </div>
        </form>
        <div id="btnCancel">
          <a href="dashboard.php"><button id="btnCancel">Cancelar</button></a>
        </div>
      </div>
    </body>
  </html>