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

if(isset($_POST['idUserHelp'],$_POST['nameHelp'], $_POST['emailHelp'], $_POST['telefoneHelp'],$_POST['descriptionHelp'])){

  $idUserHelp = $_POST['idUserHelp'];
  $nameHelp = $_POST['nameHelp'];
  $emailHelp = $_POST['emailHelp'];
  $telefoneHelp = $_POST['telefoneHelp'];
  $descriptionHelp = $_POST['descriptionHelp'];
  
  //Prepara e executa a query de inserção de valores no Banco de dados

  $sqlQueryInsert = $connection->prepare("INSERT INTO helpdesk (idUserHelp, nameHelp, emailHelp, telefoneHelp, descriptionHelp, statusHelp) VALUES (:idUserHelp, :nameHelp, :emailHelp, :telefoneHelp, :descriptionHelp, :statusHelp)");
  
  //Vincula variavéis e parâmetros
  $sqlQueryInsert->bindValue(':idUserHelp', $idUserHelp);
  $sqlQueryInsert->bindValue(':nameHelp', $nameHelp);
  $sqlQueryInsert->bindValue(':emailHelp', $emailHelp);
  $sqlQueryInsert->bindValue(':telefoneHelp', $telefoneHelp);
  $sqlQueryInsert->bindValue(':descriptionHelp', $descriptionHelp);
  $sqlQueryInsert->bindValue(':statusHelp', 'Aberto');

  $sqlQueryInsert->execute();

  // Cria o objeto PHPMailer e realiza as configurações

  $mail = new PHPMailer(true);

  try{
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
    $mail->setFrom("$emailHelp", "$nameHelp");
    $mail->addAddress('helpdesk@phphelper.com', 'Helpdesk');

    //Recupera o valor do último idHelp inserido
    $sqlQueryEmail = $connection->prepare("SELECT * FROM helpdesk ORDER BY idHelp DESC LIMIT 1");
    $sqlQueryEmail->execute();
    $row=$sqlQueryEmail->fetch();
    $idHelp = $row["idHelp"];

    //Content
    $mail->isHTML(true);
    $mail->Subject = "HELPDESK - ID: ".$idHelp;
    $mail->Body    =  "ID Helpdesk: ".$idHelp."<br>
                      ID Utilizador: ".$idUserHelp."<br>
                      Utilizador: ".$nameHelp."<br>
                      Telefone:  ".$telefoneHelp."<br>
                      Descrição:    ".$descriptionHelp;"<br>
                      Status:    ".$statusHelp;
    $mail->AltBody = "ID Helpdesk: ".$idHelp."\n
                      ID Utilizador: ".$idUserHelp."\n
                      Utilizador: ".$nameHelp."\n
                      Telefone:  ".$telefoneHelp."\n
                      Descrição:    ".$descriptionHelp;"\n
                      Status:    ".$statusHelp;

    $mail->send();
    echo 'Menssagem enviada com sucesso.';
    
  } catch (Exception $e) {
        echo "Erro! Mensagem não enviada.";
    }

  header("Location: ../dashboard.php");
  $_SESSION['msg'] = "<p>Chamado criado com sucesso.</p>";

}else{
  $_SESSION['msg'] = "<p>Erro! Chamado não criado.</p>";
  header("Location: ../dashboard.php");
}
?>