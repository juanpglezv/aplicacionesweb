<?php
// Validar que la consulta sea por tipo POST

if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    $nombre = $_POST['nombre'];
    $domicilio = $_POST['domicilio'];
    $giro= $_POST['giro'];
    $razon_social = $_POST['razon_social'];
    
    include '../lib/conn.php';

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
    echo "Error: La pagina solo carga POST.";
    exit;
}
