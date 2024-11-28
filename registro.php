<?php

//recoger datos

$nombre = $_POST['nombre'];
$pass = $_POST['contraseña'];

//configurar la conexión
$servername = "localhost"; //si cambia el puerto habría que ponerlo en este caso usa el 80 pero como es de defecto no hace falta ponerlo (localhost:80)
$username = "root"; //user del admin 
$contraseña = ""; //pass del user admin
$dbname = "pandemic"; //nombre de la base de datos que creamos

$conexion = new mysqli($servername, $username, $contraseña, $dbname);
if ($conexion->connect_error) {
    echo json_encode(["status" => "error", "message" => "No se logró registrar al usuario: $nombre"]);
    exit;
}

//para encriptar una contraseña
$hash = password_hash($pass, PASSWORD_DEFAULT);

//aqui de se cambia la variable $pass por la de $hash ---------------------------vvv
$insertarUsuario = "INSERT INTO jugador (nombre, contraseña) VALUES ('$nombre', '$hash')";
if ($conexion->query($insertarUsuario) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Se insertó correctamente a: $nombre"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se logró registrar al usuario: $nombre"]);
}

?>
