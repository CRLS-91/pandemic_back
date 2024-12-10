<?php

// Establecer encabezados para permitir el acceso desde cualquier origen y manejar solicitudes con contenido JSON
header('Access-Control-Allow-origin:*'); // Permitir el acceso desde cualquier dominio
header('Access-Control-Allow-Headers:*'); // Permitir cualquier encabezado en las solicitudes
header('Content-Type: application/json'); // Indicar que el contenido devuelto será de tipo JSON

// Recoger los datos enviados desde el cliente
$json = file_get_contents('php://input'); // Leer el cuerpo de la solicitud HTTP
$usuario = json_decode($json); // Decodificar el JSON a un objeto PHP para manipularlo fácilmente

// Configurar la conexión a la base de datos
$servername = "localhost"; // Dirección del servidor (localhost en este caso)
$username = "root"; // Nombre de usuario de la base de datos (por defecto, root)
$password = ""; // Contraseña del usuario (en este caso, vacía para configuraciones locales)
$dbname = "pandemic"; // Nombre de la base de datos utilizada en este proyecto

// Crear una nueva conexión a la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    // Enviar un mensaje de error en formato JSON y salir del script si la conexión falla
    echo json_encode(["status" => "error", "message" => "No se logró registrar al usuario: $nombre"]);
    exit;
}

// **NOTA:** Si en el futuro es necesario encriptar contraseñas, puede usarse la función `password_hash`.
// Por ejemplo: `$hash = password_hash($pass, PASSWORD_DEFAULT);`

// **NOTA:** Si usamos `$hash` para almacenar contraseñas, el SQL debería modificarse para utilizar `$hash`.
// Ejemplo del SQL modificado (comentado a continuación):
// $insertarUsuario = "INSERT INTO jugador (nombre, contraseña) VALUES ('$nombre', '$hash')";

// Insertar los datos del usuario en la tabla `jugador`
// En este caso, no se está utilizando encriptación para la contraseña (directamente `$usuario->password`)
$insertarUsuario = "INSERT INTO jugador (nombre, email, password) VALUES ('$usuario->nombre', '$usuario->email', '$usuario->password')";

// Ejecutar la consulta para insertar los datos
if ($conexion->query($insertarUsuario) === TRUE) {
    // Si la inserción fue exitosa, enviar un mensaje de éxito en formato JSON
    echo json_encode(["status" => "success", "message" => "Se insertó correctamente a: $usuario->nombre"]);
} else {
    // Si ocurre un error durante la inserción, enviar un mensaje de error en formato JSON
    echo json_encode(["status" => "error", "message" => "No se logró registrar al usuario: $usuario->nombre"]);
}

// **NOTA IMPORTANTE:** Para mejorar la seguridad, sería recomendable usar sentencias preparadas (`prepared statements`) para evitar inyecciones SQL.

//para encriptar una contraseña
//$hash = password_hash($pass, PASSWORD_DEFAULT);
//aqui de se cambia la variable $pass por la de $hash ---------------------------vvv
//$insertarUsuario = "INSERT INTO jugador (nombre, contraseña) VALUES ('$nombre', '$hash')";
?>





