<?php

  session_start();

  //Recupera os valores da tabela user atribui as variaveis
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];

    require("actions/connection.php");

    //Seleciona o registo especifico conforme idCall
    $idCall = $_GET['idCall'];    
    $sqlQueryEdit = $connection->prepare("SELECT * FROM calltable WHERE idCall = $idCall");
    $sqlQueryEdit->execute();
    $row=$sqlQueryEdit->fetch();

    }else{
      header("Location: ../consultCall.php");
      $_SESSION['msg'] = "<p>Erro! Registo não encontrado.</p>";
    }  
?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>PHP HELPER</title>
      <link rel="stylesheet" type="text/css" href="style/editCall.css">
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
        <form id="newCall" method="POST" action="actions/updateCall.php">
          <span class="title">Alterar status</span>
          <div id="line">
            <div id="collum">
              <label for="idCall">ID Chamado</label>
              <input type="text" name="idCall" id="idCall" value="<?php echo $idCall; ?>" readonly>
              <label for="idUserCall">ID Utilizador</label>
              <input type="text" name="idUserCall" id="idUserCall" value="<?php echo $row["idUserCall"]; ?>" readonly>
              <label for="telefoneCall">Telefone</label>
              <input type="text" name="telefoneCall" id="telefoneCall" value="<?php echo $row["telefoneCall"]; ?>" readonly>
              <label for="typeCall">Tipo de Chamada</label>
              <input list="typeCall" name="typeCall"required="required" value="<?php echo $row["typeCall"]; ?>" readonly>
              <datalist id="typeCall">
                <option value="Rotina">
                <option value="Urgente">
              </datalist> 
              <label for="room">nº Quarto</label>
              <input type="number" name="room" id="room" value="<?php echo $row["room"]; ?>" readonly>            
            </div>
            <div  id="collum">
              <label for="nameCall">Nome</label>
              <input type="text" name="nameCall" id="nameCall" value="<?php echo $row["nameCall"]; ?>" readonly>
              <label for="emailCall">E-mail</label>
              <input type="email" name="emailCall" id="emailCall" value="<?php echo $row["emailCall"]; ?>" readonly>
              <label for="local">Local</label>
              <input list="local" name="local" id="local" value="<?php echo $row["local"]; ?>" required="required" readonly>
              <label for="dateCall">Data Ocorrência</label>
              <input type="date" name="dateCall" id="dateCall" value="<?php echo $row["dateCall"];?>" require="required" readonly> 
              <label for="status">Status</label>
              <input list="status" name="status" value="<?php echo $row["status"]; ?>" autocomplete="off" onfocus="this.value=''" required="required">
              <datalist id="status">
                <option value="Aberto">
                <option value="Em andamento">
                <option value="Fechada">
              </datalist>          
            </div>
          </div>
          <div id="lineText" style="display:inline-block;">
            <label for="description">Solicitação / Problema</label>
            <textarea name="description" id="description" required="required" readonly><?php echo $row["description"]; ?></textarea>
          </div>
          <div id="buttons">
            <div id="button">
            <button id="btnInsertUser">Alterar</button>
          </div>
        </form>
        <div id="btnCancel">
          <input type="button" value="Cancelar" onclick="window.location = '../php_helper/consultCall.php'"/>
        </div>
      </div>
    </body>
  </html>