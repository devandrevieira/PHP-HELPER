<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../lib/vendor/autoload.php';

session_start();
ob_start();
include_once "connection.php";

if(isset($_POST['id'],$_POST['name'], $_POST['email'], $_POST['telefone'], $_POST['typeCall'], $_POST['local'], $_POST['room'], $_POST['dateCall'], $_POST['description'])){

  $idUserCall = $_POST['id'];
  $nameCall = $_POST['name'];
  $emailCall = $_POST['email'];
  $telefoneCall = $_POST['telefone'];
  $typeCall = $_POST['typeCall'];
  $local = $_POST['local'];
  $room= $_POST['room'];
  $dateCall = $_POST['dateCall'];
  $description = $_POST['description'];
  
    $queryInsert = "INSERT INTO calltable (idUserCall, nameCall, emailCall, telefoneCall, typeCall, local, room, dateCall, description, status) VALUES(:idUserCall, :nameCall, :emailCall, :telefoneCall, :typeCall,  :local, :room, :dateCall, :description,'Aberta')";
    
    $query = $connection->prepare($queryInsert);
    $result = $query->execute(array(
    
    ":idUserCall" => $idUserCall,
    ":nameCall" => $nameCall,
    ":emailCall" => $emailCall,
    ":telefoneCall" => $telefoneCall,
    ":typeCall" => $typeCall,
    ":local" => $local,
    ":room" => $room,
    ":dateCall" => $dateCall,
    ":description" => $description,

  ));

  $mail = new PHPMailer(true);

  try {
    //Server settings
    $mail->SMTPDebug  = SMTP::DEBUG_SERVER; 
    $mail->CharSet    = 'UTF-8';  
    $mail->isSMTP();                          
    $mail->Host       = 'smtp.mailtrap.io';   
    $mail->SMTPAuth   = true;                 
    $mail->Username   = 'da7416afd05920';  
    $mail->Password   = 'f98779fcf25bf9';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 2525;

    //Recipients
    $mail->setFrom("$email", "$name");
    $mail->addAddress('manutencao@example.net', 'Manutenção');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Chamado de Manutenção: ".$typeCall;
    $mail->Body    = "Utlizador: ".$nameCall."<br>
                      Telefone:  ".$telefoneCall."<br>
                      Local:     ".$local."<br>
                      Número:    ".$room."<br>
                      Descrição:    ".$description;
    $mail->AltBody = "Utlizador: ".$nameCall."\n
                      Telefone:  ".$telefoneCall."\n
                      Local:     ".$local."\n
                      Número:    ".$room."\n
                      Descrição:    ".$description;;

    $mail->send();
    echo 'Menssagem enviada com sucesso.';
} catch (Exception $e) {
    echo "Erro! Mensagem não enviada.";
}

  header("Location: ../consultCall.php");
  $_SESSION['msg'] = "<p>Chamada criada com sucesso.</p>";
}else{
  $_SESSION['msg'] = "<p>Erro! Chamada não criada.</p>";
  header("Location: ../consultCall.php");
 }

?>

