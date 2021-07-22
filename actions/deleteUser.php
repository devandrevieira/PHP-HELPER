<?php
session_start();
ob_start();
include_once "connection.php";

$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);
var_dump($id);

if (empty($id)){
 $_SESSION['msg'] = "<p>Erro! Registo de utilizador não encontrado.</p>";
  header("Location: ../managerUser.php");
  exit();
}

$query = "SELECT id FROM user WHERE id = $id LIMIT 1";
$result= $connection->prepare($query);
$result->execute();

if(($result) and ($result->rowCount() != 0)){
 $queryDelete = "DELETE FROM user WHERE id = $id";
 $resultDelete = $connection->prepare($queryDelete);
 
 if($resultDelete->execute()){
  $_SESSION['msg'] = "<p>Utilizador excluido com sucesso!.</p>";
  header("Location: ../managerUser.php");
 }else{
  $_SESSION['msg'] = "<p>Erro! Utilizador não excluido.</p>";
  header("Location: ../managerUser.php");
 }
}else{
  $_SESSION['msg'] = "<p>Erro! Registo de utilizador não encontrado.</p>";
  header("Location: ../managerUser.php");
}
?>

