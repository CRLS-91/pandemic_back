<?php

// Configurar la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pandemic";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "No se pudo recuperar la lista de usuarios"]);
    exit;
}

$select_usuarios = "SELECT * from jugador";
$resultado = $conn->query($select_usuarios);

if ($resultado->num_rows > 0) {
    $jugador = [];
    while ($fila = $resultado->fetch_assoc()) {
        $usuarios[] = ["idjugador" => $fila['idjugador'], "nombre" => $fila['nombre'], "contraseña" => $fila['contraseña']];
    }
    echo json_encode(["status" => "success", "data" => $jugador]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo recuperar la lista de usuarios"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style></style>
    <title>Document</title>
</head>
<body>
    <h1>Mostrar usuarios</h1>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>nombre</th>
                <th>password</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $resultado->data_seek(0); // Reiniciar el puntero del resultado para reutilizarlo
            while ($fila = $resultado->fetch_assoc()) { // El = es asignación
                echo "<tr>
                <td>" . $fila['idjugador'] . "</td>
                <td>" . $fila['nombre'] . "</td>
                <td>" . $fila['contraseña'] . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
