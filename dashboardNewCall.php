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
      echo "<script>window.location = '../php_helper/index.html'</script>";
    }
?>
  <!DOCTYPE html>
  <html lang="pt-br">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>PHP HELPER</title>
      <link rel="stylesheet" type="text/css" href="style/dashboardNewCall.css">
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
        <form id="newCall" method="POST" action="actions/insertCall.php">
          <span class="title">novo chamado</span>
          <div id="line">
            <div id="collum">
              <label for="id">ID Utilizador</label>
              <input type="text" name="id" id="id" value="<?php echo $id; ?>" readonly>
              <label for="telefone">Telefone</label>
              <input type="text" name="telefone" id="telefone" value="<?php echo $telefone; ?>" readonly>
              <label for="typeCall">Tipo de Chamada</label>
              <input list="typeCall" name="typeCall" placeholder="Escolha o tipo" autocomplete="off" required="required" onfocus="this.value = ''">
              <datalist id="typeCall">
                <option value="Rotina">
                <option value="Urgente">
                <option value="Programada">
              </datalist> 
              <label for="room">nº Quarto</label>
              <input type="text" name="room" id="room" placeholder="Número do quarto SE PLICÁVEL" autocomplete="off">            
            </div>
            <div  id="collum">
              <label for="name">Nome</label>
              <input type="text" name="name" id="name" value="<?php echo $name; ?>" readonly>
              <label for="email">E-mail</label>
              <input type="email" name="email" id="email" value="<?php echo $email; ?>" readonly>
              <label for="local">Local</label>
              <input list="local" name="local" placeholder="Local da ocorrência" autocomplete="off" required="required" onfocus="this.value = ''">
              <datalist id="local">
                <option value="Quartos">
                <option value="Restaurantes">
                <option value="Cozinhas">
              </datalist> 
              <label for="dateCall">Data Ocorrência</label>
              <input type="date" name="dateCall" id="dateCall" autocomplete="off" require="required">          
            </div>
          </div>
          <div id="lineText" style="display:inline-block;">
            <label for="description">Solicitação / Problema</label>
            <textarea name="description" id="description" placeholder="Reporte o problema aqui..." maxlength="2000" autocomplete="off" required="required"></textarea>
          </div>
          <div id="buttons">
            <div id="button">
            <button id="btnInsertCall">Inserir</button>
          </div>
        </form>
        <div id="btnCancel">
          <input type="button" value="Cancelar" onclick="window.location = '../php_helper/consultCall.php'"/>
        </div>
      </div>
    </body>
  </html>
