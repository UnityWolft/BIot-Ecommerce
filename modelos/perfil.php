<?php
session_start();

if(!isset($_SESSION["id"])){
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil</title>
</head>
<body>

<h1>Bienvenido <?php echo $_SESSION["nombre"]; ?></h1>

<p>Correo: <?php echo $_SESSION["correo"]; ?></p>

<a href="logout.php">Cerrar sesión</a>

</body>
</html>