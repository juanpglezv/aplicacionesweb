
<?php
// Variables de conexion a la base de datos
    $server = "localhost";
    $user = "root";
    $pass = "";
    $bd = "mipagina";
    // Crear la conexion
    $conexion = new mysqli($server, $user, $pass,$bd );
    // Verificar la conexion
    if($conexion->connect_error){
        die("Conexion fallida:" . $conexion->connection_error);
    }else{
        //echo "Conexion exitosa";
    }

?>