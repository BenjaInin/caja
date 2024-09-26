<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tipo'])) {
        // Manejo de depósitos y retiros
        $tipo = $_POST['tipo'];
        $monto = $_POST['monto'];
        
        if ($tipo == 'deposito') {
            $sql = "UPDATE usuarios SET saldo = saldo + ? WHERE id = ?";
        } elseif ($tipo == 'retiro') {
            $sql = "UPDATE usuarios SET saldo = saldo - ? WHERE id = ?";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $monto, $user_id);
        
        if ($stmt->execute()) {
            $transaccion_sql = "INSERT INTO transacciones (usuario_id, tipo, monto) VALUES (?, ?, ?)";
            $transaccion_stmt = $conn->prepare($transaccion_sql);
            $transaccion_stmt->bind_param("isd", $user_id, $tipo, $monto);
            $transaccion_stmt->execute();
//          echo "Transacción exitosa.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['prestamo'])) {
        // Manejo de préstamos
        $monto = $_POST['prestamo_monto'];
        $interes = $_POST['interes'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_vencimiento = $_POST['fecha_vencimiento'];
        
        $sql = "INSERT INTO prestamos (usuario_id, monto, interes, fecha_inicio, fecha_vencimiento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idsss", $user_id, $monto, $interes, $fecha_inicio, $fecha_vencimiento);
        
        if ($stmt->execute()) {
            echo "Préstamo registrado exitosamente.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$sql = "SELECT saldo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($saldo);
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
<!---->            <img src="img/Mountain.png" alt="Logo de la marca" >
        </a>
        </div>
        <nav>
           <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="carga.php">Ahorros</a></li>
                <li><a href="#">Prestamos</a></li>
           </ul>            
        </nav>
        <a class="btn" href="login.php"><button>Salir</button></a>

<!---->        <a onclick="openNav()" class="menu" href="#"><button>Menu</button></a>

<!---->        <div id="mobile-menu" class="overlay">
<!---->            <a onclick="closeNav()" href="" class="close">&times;</a>
<!---->            <div class="overlay-content">
                       <a href="index.php">Inicio</a>
<!---->                <a href="#">Ahorros</a>
<!---->                <a href="#">Prestamos</a>
<!---->                <a href="#">Salir</a>
<!---->            </div>
<!---->        </div>

    </header>


<!---->    <script type="text/javascript" src="js/nav.js"></script>
    
<h2>Saldo: $<?php echo number_format($saldo, 2); ?></h2>
<form method="post">
    Tipo: 
    <select name="tipo">
        <option value="deposito">Depósito</option>
        <option value="retiro">Retiro</option>
    </select><br>
    Monto: <input type="number" step="0.01" name="monto" required><br>
    <input type="submit" value="Realizar Transacción">
</form>

<h2>Solicitar Préstamo</h2>
<form method="post">
    Monto: <input type="number" step="0.01" name="prestamo_monto" required><br>
    Interés: <input type="number" step="0.01" name="interes" required><br>
    Fecha de Inicio: <input type="date" name="fecha_inicio" required><br>
    Fecha de Vencimiento: <input type="date" name="fecha_vencimiento" required><br>
    <input type="submit" name="prestamo" value="Solicitar Préstamo">
</form>
</div>
</body>
</html>
