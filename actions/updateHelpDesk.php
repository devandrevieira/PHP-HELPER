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
if(isset($_POST['idHelp'], $_POST['statusHelp'])){  
  $idHelp = $_POST['idHelp'];
  $idUserHelp = $_POST['idUserHelp'];
  $nameHelp = $_POST['nameHelp'];
  $emailHelp = $_POST['emailHelp'];
  $telefoneHelp = $_POST['telefoneHelp'];
  $descriptionHelp = $_POST['descriptionHelp'];
  $statusHelp = $_POST['statusHelp'];

    //Prepara e executa a query de update no Banco de dados
    $sqlQueryUpdate = $connection->prepare("UPDATE helpdesk SET statusHelp=? WHERE idHelp=?");
    $sqlQueryUpdate->execute([$statusHelp, $idHelp]);

    header("Location: ../consultHelpDesk.php");
    $_SESSION['msg'] = "<p>Helpdesk atualizado com sucesso.</p>";

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
    $mail->setFrom('helpdesk@phphelper.com', 'Helpdesk');
    $mail->addAddress("$emailHelp", "$nameHelp");

    //Conteúdo do email
    $mail->isHTML(true);
    $mail->Subject = "Chamado Helpdesk: ID ".$idHelp;
    $mail->Body    = "O status do chamado a seguir foi alterado para: " .$statusHelp."<br>
                      ID Chamado: ".$idHelp."<br>
                      ID Utilizador: ".$idUserHelp."<br>
                      Utilizador: ".$nameHelp."<br>
                      Descrição:    ".$descriptionHelp;
    $mail->AltBody = "O status do chamado a seguir foi alterado para: " .$statusHelp."\n
                      ID Chamado: ".$idHelp."\n
                      ID Utilizador: ".$idUserHelp."\n
                      Utilizador: ".$nameHelp."\n
                      Descrição:    ".$descriptionHelp;

    $mail->send();

    echo 'Menssagem enviada com sucesso.';
} catch (Exception $e) {
    echo "Erro! Mensagem não enviada.";
}

  }else{
      $_SESSION['msg'] = "<p>Erro! Utilizador não atualizado.</p>";
      header("Location: ../managerUser.php");
  }

?>

