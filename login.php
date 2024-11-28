<?php
// login.php

session_start();

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pandemic";

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    // Escapar los valores para evitar inyección SQL
    $nombre = $conn->real_escape_string($nombre);
    $contraseña = $conn->real_escape_string($contraseña);

    // Consultar la base de datos para verificar el usuario
    $sql = "SELECT * FROM jugador WHERE nombre = '$nombre' AND contraseña = '$hash'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario encontrado, iniciar sesión
        $_SESSION['nombre'] = $nombre;
        echo "Inicio de sesión exitoso. Bienvenido, " . $nombre . "!";
    } else {
        // Usuario no encontrado o contraseña incorrecta
        echo "Nombre de usuario o contraseña incorrectos.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>