<?php

// Permitir el acceso desde cualquier origen
header('Access-Control-Allow-Origin: *');
// Permitir cualquier encabezado en las solicitudes
header('Access-Control-Allow-Headers: *');
// Indicar que el contenido será de tipo JSON
header('Content-Type: application/json');

// Leer los datos enviados desde el cliente
$json = file_get_contents('php://input'); // Obtiene el cuerpo de la solicitud HTTP
$login = json_decode($json); // Decodifica el JSON a un objeto PHP

// Iniciar la sesión del usuario
session_start();

// Parámetros para la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pandemic";

// Crear la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    // Enviar un mensaje de error en formato JSON si la conexión falla
    die(json_encode(["status" => "error", "message" => "Error de conexión a la base de datos."]));
}

// Preparar una consulta para verificar las credenciales del usuario
$sql = "SELECT * FROM jugador WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql); // Prepara la consulta para evitar inyecciones SQL
$stmt->bind_param("ss", $login->email, $login->password); // Vincula los parámetros del email y la contraseña
$stmt->execute(); // Ejecuta la consulta
$result = $stmt->get_result(); // Obtiene los resultados de la consulta

// Verificar si las credenciales coinciden con un usuario en la base de datos
if ($result->num_rows > 0) {
    // Si se encuentra un usuario, recuperar los datos
    $row = $result->fetch_assoc();
    // Guardar el email en la sesión del usuario
    $_SESSION['email'] = $login->email;
    // Enviar una respuesta de éxito en formato JSON
    echo json_encode(["status" => "success", "message" => "Se logueó correctamente a: $login->email"]);
} else {
    // Si las credenciales son incorrectas o no se encuentra el usuario
    echo json_encode(["status" => "error", "message" => "Credenciales incorrectas."]);
}

// Cerrar la conexión a la base de datos para liberar recursos
$conn->close();
?>
