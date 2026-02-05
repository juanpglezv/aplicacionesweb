<?php
// Validar que la consulta sea por tipo POST

if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    $nombre = $_POST['nombre'];
    $domicilio = $_POST['domicilio'];
    $giro= $_POST['giro'];
    $razon_social = $_POST['razon_social'];

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
        echo "Conexion exitosa";
    }
    //Insertar datos en db
    $sql = "INSERT INTO clientes (nombre, domicilio, giro, razon_social)".
        " VALUES('".$nombre."', '".$domicilio."','".$giro."','".$razon_social."')";
    //Ejecutar consulta
    if ($conexion->query($sql) == TRUE) {
        $mensaje = "<br> Nuevo registro creado exitosamente";
    } else{
       $mensaje =  "Error" .$sql ."<br>" .$conexion->error;
    }
    //Cerrar conexion
    $conexion->close();
    //Redirigir a otra pagina con mensaje exitoso o error
    header("Location: index.php?mensaje=". urlencode($mensaje));
    exit;
    echo "<br><br> Si se ejecuto";
}else {
    echo "Error: La pagina solos carga POST.";
    exit;
}
