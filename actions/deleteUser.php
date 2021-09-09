<?php

session_start();
ob_start();

include_once "connection.php";

//Recuepera o valor do ID através do metódo GET
$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);

if (empty($id)){
 $_SESSION['msg'] = "<p>Erro! Registo de utilizador não encontrado.</p>";
  header("Location: ../managerUser.php");
  exit();
}

//Prepara a consulta ao registo selecionado
$sqlQuery = $connection->prepare("SELECT id FROM user WHERE id = $id LIMIT 1");
$sqlQuery->execute();

//Verifica se um registo foi encontrado
if(($sqlQuery) and ($sqlQuery->rowCount() != 0)){
  
  //Executa a query Delete no ID selecionado
  $sqlQueryDelete = $connection->prepare("DELETE FROM user WHERE id = $id");
 
    if($sqlQueryDelete->execute()){
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

