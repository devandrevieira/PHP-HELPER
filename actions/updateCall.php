<?php
session_start();
ob_start();
include_once "connection.php";

if(isset($_POST['idCall'],$_POST['status'])){

  $idCall = $_POST['idCall'];
  $status = $_POST['status'];
  
    $queryInsert = "UPDATE calltable SET status = :status WHERE idCall = :idCall";
    
    $query = $connection->prepare($queryInsert);
    $result = $query->execute(array(
    
    ":idCall" => $idCall,
    ":status" => $status,

  ));

    header("Location: ../consultCall.php");
    $_SESSION['msg'] = "<p>Status atualizado com sucesso.</p>";

}else{
    $_SESSION['msg'] = "<p>Erro! Status não atualizado.</p>";
    header("Location: ../consultCall.php");
}

?>

