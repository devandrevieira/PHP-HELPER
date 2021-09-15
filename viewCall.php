<?php

  session_start();

  //Recupera os valores da tabela user atribui as variaveis
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];
    require("actions/connection.php");

    $idCall = $_GET['idCall'];
    $query = $connection->prepare("SELECT * FROM calltable WHERE idCall = $idCall");
    $query->execute();
    $row=$query->fetch();

    }else{
      echo "<script>window.location = '../php_helper/index.html'</script>";
    }  
?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>PHP HELPER</title>
      <link rel="stylesheet" type="text/css" href="style/viewCall.css">
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
          <div id="return">
            <a href="consultCall.php"><button>Voltar</button></a>
            </div>
          <div id="logout">
            <a href="actions/logout.php"><button>Logout</button></a>
          </div>
        </div>
      </header>
      
      <div id=form>
        <form id="newCall" method="GET" action="actions/insertCall.php">
          <span class="title">Visualizar Chamado</span>
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
              <label for="nameCallCall">Nome</label>
              <input type="text" name="nameCall" id="nameCall" value="<?php echo $row["nameCall"]; ?>" readonly>
              <label for="emailCall">E-mail</label>
              <input type="email" name="emailCall" id="emailCall" value="<?php echo $row["emailCall"]; ?>" readonly>
              <label for="local">Local</label>
              <input list="local" name="local" id="local" value="<?php echo $row["local"]; ?>" required="required" readonly>
              <label for="dateCall">Data Ocorrência</label>
              <input type="date" name="dateCall" id="dateCall" value="<?php echo $row["dateCall"];?>" require="required" readonly> 
              <label for="status">Status</label>
              <input list="status" name="status" id="status" value="<?php echo $row["status"]; ?>" required="required" readonly>  
            </div>
          </div>
          <div id="lineText" style="display:inline-block;">
            <label for="description">Solicitação / Problema</label>
            <textarea name="description" id="description" required="required" readonly><?php echo $row["description"]; ?></textarea>
          </div>
        </form>
      </div>
    </body>
  </html>