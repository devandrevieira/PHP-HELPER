<?php
session_start();
ob_start();
include_once "connection.php";

$query = "SELECT * FROM user";
$result= $connection->prepare($query);
$result->execute();

if(isset($_POST['name'], $_POST['email'], $_POST['telefone'], $_POST['keyword'], $_POST['admin'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $keyword = $_POST['keyword'];
  $admin = $_POST['admin'];

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
    MD5(:keyword),
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

