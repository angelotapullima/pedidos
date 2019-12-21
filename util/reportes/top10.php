<?php
include("../system/funciones.php");
include("../system/session.php");
include("../system/conexion.php");

$conexion = new Conexion('../logs/');
$conexion->conectar();

# Obtener los parametros del sistema

$resultado_parametros = $conexion->ejecutarConsulta("
    SELECT * FROM parametros
");

$parametro = array();

foreach($resultado_parametros as $fila){
    $parametro[trim($fila['parametro'])] = trim($fila['valor']);
}

#######################################

$session = new Session();

$respuesta = new stdClass();
$respuesta->estado = 1;
$respuesta->mensaje = "";
$respuesta->data = array();
$respuesta->total_pedido = 0;

try{

    if( !$session->checkSession() ) throw new Exception("Debe iniciar una sesión");
 
    $fechain = '';
    $fechafin = '';

    if(
        isset($_POST['fecha1']) &&
        isset($_POST['fecha2'])
    ){
        $fechain = $_POST['fecha1'];
        $fechafin = $_POST['fecha2'];
    }

    if( empty($fechain) ){
        throw new Exception("No Seleccionó fecha Inicio");
    }
    if( empty($fechafin) ){
        throw new Exception("No Seleccionó fecha Final");
    }
    if( $fechafin > date('Y-m-d') || $fechain > date('Y-m-d')){
        throw new Exception("Fecha no permitida");
    }
    if( $fechafin < $fechain){
        throw new Exception("La fecha final debe ser mayor que la fecha Inicio");
    }

    $resultado = $conexion->ejecutarConsulta("
        SELECT a.cliente, b.nombre ,SUM(a.total) AS total 
        FROM pedidos_cabecera AS a 
        INNER JOIN clientes AS b ON (a.cliente=b.documento) 
        WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59' 
        AND a.estado='PAGADO' 
        GROUP BY a.cliente 
        ORDER BY total DESC 
        LIMIT 10
    ");

    foreach($resultado as $fila){
        $respuesta->data[] = $fila;
    }

}catch(Exception $e){
    $respuesta->estado = 2;
    $respuesta->mensaje = $e->getMessage();
}

print_r(json_encode($respuesta));