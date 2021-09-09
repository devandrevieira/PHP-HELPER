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
if(isset($_POST['idCall'], $_POST['idUserCall'], $_POST['nameCall'], $_POST['emailCall'], $_POST['local'], $_POST['room'], $_POST['status'], $_POST['description'])){

  $idCall = $_POST['idCall'];
  $idUserCall = $_POST['idUserCall'];
  $nameCall = $_POST['nameCall'];
  $emailCall = $_POST['emailCall'];
  $local = $_POST['local'];
  $room = $_POST['room'];
  $description = $_POST['description'];
  $status = $_POST['status'];

  
    //Prepara e executa a query de update no Banco de dados
    $sqlQueryUpdate = $connection->prepare("UPDATE calltable SET idUserCall=?, nameCall=?, emailCall=?, local=?, room=?, description=?, status=? WHERE idCall = ?");

    $sqlQueryUpdate->execute([$idUserCall, $nameCall, $emailCall, $local, $room, $description, $status, $idCall]);

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
    $mail->setFrom('manutencao@hotel.com', 'Manutencao');
    $mail->addAddress("$emailCall", "$nameCall");

    //Conteúdo do email
    $mail->isHTML(true);
    $mail->Subject = "Chamado de Manutenção: ID ".$idCall;
    $mail->Body    = "O status do chamado a seguir foi alterado para: " .$status."<br>
                      ID Chamado: ".$idCall."<br>
                      Utilizador: ".$nameCall."<br>
                      Local:     ".$local."<br>
                      Número Quarto:    ".$room."<br>
                      Descrição:    ".$description;
    $mail->AltBody = "O status do chamado a seguir foi alterado para: " .$status."\n
                      ID Chamado: ".$idCall."\n
                      Utilizador: ".$nameCall."\n
                      Local:     ".$local."\n
                      Número Quarto:    ".$room."\n
                      Descrição:    ".$description;

    $mail->send();

    echo 'Menssagem enviada com sucesso.';
} catch (Exception $e) {
    echo "Erro! Mensagem não enviada.";
}

    header("Location: ../consultCall.php");
    $_SESSION['msg'] = "<p>Status atualizado com sucesso.</p>";

    }else{
        $_SESSION['msg'] = "<p>Erro! Status não atualizado.</p>";
        header("Location: ../consultCall.php");
}

?>

