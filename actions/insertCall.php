<?php

//Importa bibliotecas PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../lib/vendor/autoload.php';

session_start();
ob_start();
include_once "connection.php";

//Verifica e recebe dados via POST

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

  //Prepara e executa a query de inserção de valores no Banco de dados
  
  $sqlQueryInsert = $connection->prepare ("INSERT INTO calltable (idUserCall, nameCall, emailCall, telefoneCall, typeCall, local, room, dateCall, description, status) VALUES(:idUserCall, :nameCall, :emailCall, :telefoneCall, :typeCall,  :local, :room, :dateCall, :description,'Aberto')");
  
  //Vincula variavéis e parâmetros
  $sqlQueryInsert->bindValue(':idUserCall', $idUserCall);
  $sqlQueryInsert->bindValue(':nameCall', $nameCall);
  $sqlQueryInsert->bindValue(':emailCall', $emailCall);
  $sqlQueryInsert->bindValue(':telefoneCall', $telefoneCall);
  $sqlQueryInsert->bindValue(':typeCall', $typeCall);
  $sqlQueryInsert->bindValue(':local', $local);
  $sqlQueryInsert->bindValue(':room', $room);
  $sqlQueryInsert->bindValue(':dateCall', $dateCall);
  $sqlQueryInsert->bindValue(':description', $description);

  $sqlQueryInsert->execute();

  // Cria o objeto PHPMailer e realiza as configurações

  $mail = new PHPMailer(true);

  try {
    //Configurações do servidor
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '098daca6479457';
    $mail->Password = '73df84d258fb0f';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 

    //Recipientes
    $mail->setFrom("$emailCall", "$nameCall");
    $mail->addAddress('manutencao@hotel.com', 'Manutencao');

    //Recupera o valor do último idCall inserido
    $sqlQueryEmail = $connection->prepare("SELECT * FROM calltable ORDER BY idCall DESC LIMIT 1");
    $sqlQueryEmail->execute();
    $row=$sqlQueryEmail->fetch();
    $idCall = $row["idCall"];

    //Conteúdo do email
    $mail->isHTML(true);
    $mail->Subject = "Chamado de Manutenção ID : ".$idCall." - ".$typeCall;
    $mail->Body    = "Utilizador: ".$nameCall."<br>
                      Telefone:  ".$telefoneCall."<br>
                      Local:     ".$local."<br>
                      Número Quarto:    ".$room."<br>
                      Descrição:    ".$description;
    $mail->AltBody = "Utilizador: ".$nameCall."\n
                      Telefone:  ".$telefoneCall."\n
                      Local:     ".$local."\n
                      Número:    ".$room."\n
                      Descrição:    ".$description;

    $mail->send();

    echo 'Menssagem enviada com sucesso.';
} catch (Exception $e) {
    echo "Erro! Mensagem não enviada.";
}

  header("Location: ../consultCall.php");
  $_SESSION['msg'] = "<p>Chamada criado com sucesso.</p>";
}else{
  $_SESSION['msg'] = "<p>Erro! Chamado não criado.</p>";
  header("Location: ../consultCall.php");
 }

?>

