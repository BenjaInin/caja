<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidomat = $_POST['apellidomat'];
    $apellidopat = $_POST['apellidopat'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre, apellidomat, apellidopat, telefono, email, contrasena) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $apellidomat, $apellidopat, $telefono, $email, $contrasena);
    if ($stmt->execute()) {
        echo'<script type="text/javascript">
        alert("Tarea Guardada");
        </script>';
       } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
 
</head>

<body>

    <div class="contenedor-formulario contenedor">
        <div class="imagen-formulario">
        </div>
        <form method="post" class="formulario">
            <div class="texto-formulario">
                <h2>¡Bienvenido registrate!</h2>
                <p>Por favor ingresa tus datos</p>
            </div>
            <div class="input">
                <label for="usuario">Nombre</label>
                <input type="text" name="nombre" placeholder="Ingresa tu nombre" required>
            </div>
            <div class="input">
                <label for="usuario">Apellidos</label>
                <input type="text" name="apellidomat" placeholder="Ingresa tu apellido materno" required>
            </div>
            <div class="input">
                <label for="usuario"></label>
                <input type="text" name="apellidopat" placeholder="Ingresa tu apellido paterno" required>
            </div>
            <div class="input">
                <label for="usuario">telefono</label>
                <input type="text" name="telefono" placeholder="Ingresa tu numero telefonico o celular" required>
            </div>
            <div class="input">
                <label for="contraseña">Correo</label>
                <input type="email" name="email" id="correo"  placeholder="Ingresa tu correo" required>
            </div>
            <div class="input">
                <label for="contraseña">Contraseña</label>
                <input  type="password" id="password" name="contrasena" placeholder="Ingresa tu conteseña" required>
            </div>
            <div class="input">
            <input type="submit" value="Registrar">
            </div>
            <div class="input">
            <a href="login.php"> 
                <input type="button" value="Login">
            </a>
            </div>
        </form>

     
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="js/sweetAlert.js"></script> -->
</body>

</html>