<?php
  require("connection.php");

  if(isset($_POST["email"]) && isset($_POST["keyword"]) && $connection != null){
    $query = $connection->prepare("SELECT * FROM user WHERE email = ? AND keyword = ?");
    $query->execute(array($_POST["email"], md5($_POST["keyword"])));

    if($query->rowCount()){
      $user = $query->fetchAll(PDO::FETCH_ASSOC)[0];

      session_start();
      $_SESSION["user"] = array($user["name"], $user["admin"]);

      echo json_encode(array("erro"=>0));
      
    }else{
      echo json_encode(array("error"=>1, "message"=>"E-mail e / ou Senha, incorretos!"));
    }
  }else{
    echo json_encode(array("error"=>1, "message"=>"Erro local de conexão"));
  }
?>