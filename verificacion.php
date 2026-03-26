<?php
//Valida que el formulario se envie por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Tomar los datos tipo post del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        echo "Por favor, complete todos los campos.";
        exit;
    }
    // conexion a la base de datos
    include "lib/conn.php";
    // encriptar la contraseña usando md5
    $password = md5($password);
    // Consulta para verificar el usuario usando prepared statements para evitar inyecciones SQL
    $sql = "SELECT * FROM usuarios WHERE correo = ? AND password = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // Verifica que se encontro el usuario

    if (mysqli_num_rows($result) == 1) {
        // Iniciar sesion y almacenar el correo del usuario en la variable de sesion
        session_start();
        $_SESSION["usuario"] = $result->fetch_assoc()["nombre"];
        header("Location: dasboard.php");
        exit;
    } else {
        echo "Correo o contraseña incorrectos.";
    }
 } else {
    echo "Por favor, complete todos los campos.";

}
?>

