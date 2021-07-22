<?php
  session_start();
  if(isset($_SESSION["user"]) && is_array($_SESSION["user"])){
    $admin = $_SESSION["user"][1];
    $name  = $_SESSION["user"][0];
    require("actions/connection.php");
  }else{
    echo "<script>window.location = '../php_helper/index.html'</script>";
  }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $name; ?> - Abrir Chamado</title>
</head>
<body>
  <?php if($admin): ?>
    
  <?php endif; ?>
  <a href="actions/logout.php">SAIR</a>
</body>
</html>