<?php
session_start();
ob_start();
include_once "connection.php";

if(isset($_POST['name'], $_POST['email'], $_POST['telefone'], $_POST['keyword'], $_POST['admin'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $keyword = $_POST['keyword'];
  if ($_POST['admin'] == "Utilizador"){
    $admin = "0";
    }elseif ($_POST['admin'] == "Admnistrador"){
      $admin = "1";
    }else{
      $admin = "2";
  };

    $queryInsert = "INSERT INTO user (
    name,
    email,
    telefone,
    keyword,
    admin)
  VALUES(
    :name,
    :email,
    :telefone,
    :keyword,
    :admin)";
  $query = $connection->prepare($queryInsert);
  $result = $query->execute(array(
    ":name" => $name,
    ":email" => $email,
    ":telefone" => $telefone,
    ":keyword" => $keyword,
    ":admin" => $admin,
  ));
  header("Location: ../managerUser.php");
  $_SESSION['msg'] = "<p>Utilizador inserido com sucesso.</p>";
}else{
  $_SESSION['msg'] = "<p>Erro! Utilizador não inserido.</p>";
  header("Location: ../dashboardNewUser.php");
 }

?>

