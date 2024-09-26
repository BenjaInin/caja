<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre);
$stmt->fetch();
$stmt->close();


$sql = "SELECT monto FROM prestamos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($monto);
$stmt->fetch();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="es">
<head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/styless.css">
</head>
<body>
    <header class="header">
        <div class="logo">
        <a href="index.php">
            <img src="img/Mountain.png" alt="Logo de la marca" >
        </a>
        </div>
        <nav>
           <ul class="nav-links">
                <li><a href="carga.php">Ahorros</a></li>
                <li><a href="#">Prestamos</a></li>
           </ul>            
        </nav>
        <a class="btn" href='controller_cerrar_sesion.php'><button>Salir</button></a>

        <a onclick="openNav()" class="menu" href="#"><button>Menu</button></a>

        <div id="mobile-menu" class="overlay">
            <a onclick="closeNav()" href="" class="close">&times;</a>
            <div class="overlay-content">
                <a href="#">Ahorros</a>
                <a href="#">Prestamos</a>
                <a href="#">Salir</a>
            </div>
        </div>

    </header>


<!---->    <script type="text/javascript" src="js/nav.js"></script>
<section>
    <div class="body-table">
        <div class="container"> 
            <h2>Bienvenido  <?php echo ($nombre); ?></h2> 
            <h1>El total de tus ahorros</h1>
            <br>
            <br>
            <table >
                <thead>
                <tr>
                    <td><h2>Nombre</h2></td>
                    <td> </td>
                    <td> </td>
                    <td><h2>Saldo</h2></td>
                </tr>  
                </thead>       
            <?php
        $sql="SELECT nombre,apellidopat,apellidomat,saldo FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($nombre,$apellidopat,$apellidomat,$saldo);
        while ($stmt->fetch()){
        ?>
        <tbody>
            <tr>
                <td><h2><?php echo $nombre?></h2></td>
                <td><h2><?php echo $apellidopat?></h2> </td>
                <td><h2> <?php echo $apellidomat?></h2></td>
                <td><h2><?php echo $saldo?></h2></td>
            </tr>
        <?php
        }
        $stmt->close();
        ?>
        </tbody>
        </div>
    </div>
    
    </section>

</body>
</html>