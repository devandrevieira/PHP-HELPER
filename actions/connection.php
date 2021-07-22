<?php
  $server = "127.0.0.1";
  $user = "root";
  $password = "";
  $database = "php_helper";

  try{
    $connection = new PDO("mysql:host=$server;dbname=$database",$user,$password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch(PDOException $error){
    //echo "Erro de conexão: {$erro->getMessage()}";
    $connection = null;
  }
?>