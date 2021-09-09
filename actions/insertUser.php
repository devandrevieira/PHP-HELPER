<?php

session_start();
ob_start();

include_once "connection.php";

//Verifica e recebe dados via POST

if(isset($_POST['name'], $_POST['email'], $_POST['telefone'], $_POST['keyword'], $_POST['admin'])){
  
  $name      = $_POST['name'];
  $email     = $_POST['email'];
  $telefone  = $_POST['telefone'];
  $keyword   = $_POST['keyword'];
  
  if ($_POST['admin'] == "Utilizador"){
    $admin   = "0";
    }elseif ($_POST['admin'] == "Admnistrador"){
      $admin = "1";
    }else{
      $admin = "2";
  };

    //Verifica redundancia de utilizador

    $sqlQueryInsert = $connection->prepare("SELECT * FROM user WHERE email = :email");
    $sqlQueryInsert->bindValue (':email', $email);
    $sqlQueryInsert->execute();

    if($sqlQueryInsert->rowCount()===0){

    //Prepara e executa a query de inserção de valores no Banco de dados

    $sqlQueryInsert = $connection->prepare("INSERT INTO user (name, email, telefone, keyword, admin) VALUES (:name, :email, :telefone, :keyword, :admin)");
    
    //Vincula variavéis e parâmetros
    $sqlQueryInsert->bindValue(':name', $name);
    $sqlQueryInsert->bindValue(':email', $email);
    $sqlQueryInsert->bindValue(':telefone', $telefone);
    $sqlQueryInsert->bindValue(':keyword', $keyword);
    $sqlQueryInsert->bindValue(':admin', $admin);
    
    $sqlQueryInsert->execute();
    
    header("Location: ../managerUser.php");
    $_SESSION['msg'] = "<p>Utilizador inserido com sucesso.</p>";
    
    }else{
      header("Location: ../managerUser.php");
      $_SESSION['msg'] = "<p>Erro! E-mail já Cadastrado. Utilizador não inserido</p>";
      }
}else{
  header("Location: ../dashboardNewUser.php");
  $_SESSION['msg'] = "<p>Erro! Utilizador não inserido.</p>";
}
?>

