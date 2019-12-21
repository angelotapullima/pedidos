<?php
include("../system/funciones.php");
include("../system/session.php");
include("../system/conexion.php");

$conexion = new Conexion('../logs/');
$conexion->conectar();

$session = new Session();

$respuesta = new stdClass();
$respuesta->estado = 1;
$respuesta->mensaje = "";
$respuesta->data = array();

try{

    if( !$session->checkSession() ) throw new Exception("Debe iniciar una sesión");

    $resultado = $conexion->ejecutarConsulta("
        
        SELECT SUM(total) AS total, date(fecha_creacion) AS fecha
        FROM pedidos_cabecera
        WHERE estado = 'PAGADO'
        GROUP BY date(fecha)
        ORDER BY fecha DESC
        LIMIT 10
    ");

    $categories = array();
    $data = array('name' => 'Ventas S/', 'data' => array());

    foreach($resultado as $fila){
        $categories[] = $fila['fecha'];
        $data['data'][] = (float)$fila['total'];
    }

    $respuesta->data['categories'] = $categories;
    $respuesta->data['series'][] = $data;

}catch(Exception $e){
    $respuesta->estado = 2;
    $respuesta->mensaje = $e->getMessage();
}

print_r(json_encode($respuesta));