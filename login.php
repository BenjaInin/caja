<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT id, contrasena FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hash);
    
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($contrasena, $hash)) {
            $_SESSION['user_id'] = $id;
            header("Location: index.php");
        } else {
            echo "Email o contraseña incorrectos.";
        }
    } else {
        echo "Email o contraseña incorrectos.";
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
    <title>Login</title>
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
                <h2>Bienvenido de nuevo</h2>
                <p>Inicia sesión con tu cuenta</p>
            </div>
            <div class="input">
                <label for="usuario">Usuario</label>
                <input type="email" id="username" name="email" placeholder="Ingresa tu correo" required>
            </div>
            <div class="input">
                <label for="contraseña">Contraseña</label>
                <input type="password" id="password" name="contrasena" placeholder="Ingresa tu conteseña" required>
            </div>
            <div class="password-olvidada">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="input">
            <a href="index.php">    
            <input type="submit" value="Login">
                </a>
            </div>
            <div class="input">
            <a href="register.php">
                <input type="button" value="Registrar">
            </a>
            </div>
        </form>
       

     
    </div>

</body>

</html>