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

try{

    if( !$session->checkSession() ) throw new Exception("Debe iniciar una sesión");

    $idpedcab = 0;

    if(
        isset($_POST['idpedcab']) && !empty($_POST['idpedcab'])
    ){
        $idpedcab = $_POST['idpedcab'];
    }

    if( 
        empty($idpedcab) 
    ){
        throw new Exception("No envió el ID del pedido");
    }

    # Actualizar el estado del pedido a facturado

    $update = $conexion->ejecutarConsulta("
        UPDATE pedidos_cabecera SET 
        estado='PAGADO',
        numero_factura='".$idpedcab."',
        usuario_actualizacion='".$_SESSION['usuario']."',
        fecha_actualizacion=NOW()
        WHERE 
        idpedcab = '".$idpedcab."'
    ");

    if( !$update ) throw new Exception("Error al actualizar el pedido");

    $respuesta->mensaje = "Pedido # ".$idpedcab.", Pagado con éxito";
        

}catch(Exception $e){
    $respuesta->estado = 2;
    $respuesta->mensaje = $e->getMessage();
}

print_r(json_encode($respuesta));