<?php

session_start();
ob_start();

include_once "connection.php";

//Verifica e recebe dados via POST
if(isset($_POST['name'], $_POST['email'], $_POST['telefone'], $_POST['keyword'], $_POST['admin'])){
  
  $id = $_GET['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $keyword = $_POST['keyword'];
  if ($_POST['admin'] == "Utilizador"){
    $admin   = "0";
    }elseif ($_POST['admin'] == "Administrador"){
      $admin = "1";
    }else{
      $admin = "2";
  };

    //Prepara e executa a query de update no Banco de dados
    $sqlQueryUpdate = $connection->prepare("UPDATE user SET id=?, name=?, email=?, telefone=?, keyword=?, admin=? WHERE id=?");
    $sqlQueryUpdate->execute([$id, $name, $email, $telefone, $keyword, $admin, $id]);

    header("Location: ../managerUser.php");
    $_SESSION['msg'] = "<p>Utilizador atualizado com sucesso.</p>";

  }else{
      $_SESSION['msg'] = "<p>Erro! Utilizador não atualizado.</p>";
      header("Location: ../managerUser.php");
  }

?>

