<?php

session_start();

if (isset($_SESSION["usuario_rol"]) && ($_SESSION["usuario_rol"] === "Cliente")) {
    // El usuario ha iniciado sesión y su rol es "cliente", permite el acceso al contenido actual
} else {
    header("Location:../../registro.php?alerta=iniciar_sesion_primero");
    exit();
}

$datos = array(); // Inicializar el arreglo de datos

if (isset($_POST['txtID'])) {
    $txtID = $_POST['txtID'];
    
    if($txtID == $txtID){
        if (isset($_SESSION['carrito']['productos'][$txtID])) {
            $_SESSION['carrito']['productos'][$txtID] += 1;
        } else {
            $_SESSION['carrito']['productos'][$txtID] = 1;
        }
    
        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
    } else {
        $datos['ok'] = false;
    }  
}else {
    $datos['ok']= false;
}

echo json_encode($datos);
