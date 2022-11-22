<?php
$host="localhost";
$db="konecta";
$usuario="";
$contrasenia="";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$db", $usuario, $contrasenia);
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>