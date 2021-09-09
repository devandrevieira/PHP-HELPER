<?php

  session_start();

  //Recupera os valores da tabela user atribui as variaveis
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];

    require("actions/connection.php");

    //Seleciona o registo especifico conforme idHelp
    $idHelp = $_GET['idHelp'];
    $query = $connection->prepare("SELECT * FROM helpdesk WHERE idHelp = $idHelp");
    $query->execute();
    $row=$query->fetch();

    }else{
      header("Location: ../consultHelpDesk.php");
      $_SESSION['msg'] = "<p>Erro! Registo não encontrado.</p>";
    }  
?>
<!-- Permite o acesso apenas para utilizadore com perfil Administrador -->
<?php if($admin): ?>
  <!DOCTYPE html>
  <html lang="pt-br">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>PHP HELPER</title>
      <link rel="stylesheet" type="text/css" href="style/editHelpDesk.css">
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
        <form id="newUser" method="POST" action="actions/updateHelpDesk.php?idHelp=<?=$row["idHelp"] ?>">
          <span class="title">editar helpdesk</span>
          <div id="line">
            <label for="idHelp">ID helpdesk</label>
            <input type="number" name="idHelp" id="idHelp" value="<?php echo $row["idHelp"]; ?>" autocomplete="off" required="required" readonly>
            <label for="idUserHelp">ID Utilizador</label>
            <input type="number" name="idUserHelp" id="idUserHelp" value="<?php echo $row["idUserHelp"]; ?>" autocomplete="off" required="required" readonly>
            <label for="nameHelp">Nome Utilizador</label>
            <input type="text" name="nameHelp" id="nameHelp" value="<?php echo $row["nameHelp"]; ?>" autocomplete="off" required="required" readonly>
            <label for="name">E-mail</label>
            <input type="emailHelp" name="emailHelp" id="emailHelp" value="<?php echo $row["emailHelp"]; ?>" autocomplete="off" required="required" readonly>
            <label for="telefoneHelp">Telefone</label>
            <input type="text" name="telefoneHelp" id="telefoneHelp" value="<?php echo $row["telefoneHelp"]; ?>" autocomplete="off" required="required" readonly>
              <div id="lineText" style="display:inline-block;">
              <label for="descriptionHelp">Solicitação / Problema</label>
              <textarea name="descriptionHelp" id="descriptionHelp" required="required" readonly><?php echo $row["descriptionHelp"]; ?></textarea>
          </div>
          <label for="statusHelp">Status</label>
              <input list="statusHelp" name="statusHelp" value="<?php echo $row["statusHelp"]; ?>" autocomplete="off" onfocus="this.value=''" required="required">
              <datalist id="statusHelp">
                <option value="Aberto">
                <option value="Em andamento">
                <option value="Encerrada">
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