<?php

//recoger datos

$nombre = $_POST['nombre'];
$pass = $_POST['password'];

//configurar la conexión
$servername = "localhost"; //si cambia el puerto abria que ponerlo en este caso usa el 80 pero como es de defecto no hace falta ponerlo (localhost:80)
$username = "root";//user del admin 
$password = "";//pass del user admin
$dbname = "pandemic";//nombre de la base de datos que creamos

$conexion = new mysqli($servername, $username, $password, $dbname);
if($conexion->connect_error){
       echo "conexion fallida";
   }
   //para encriptar una contraceña
   $hash = password_hash($pass, PASSWORD_DEFAULT);

   //aqui de se cambia la variable $pass por la de $hash ---------------------------vvv
   $insertarUsuario = "INSERT INTO usuarios (nombre, password) VALUES ('$nombre', '$hash')";
   $conexion->query($insertarUsuario);
   
   echo "status':'success","message':'Se logueó correctamente a: .$nombre"
   
   ?>