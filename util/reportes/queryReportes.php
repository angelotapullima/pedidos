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

    $cliente = ''; 
    $fechain = '';
    $fechafin = '';
    $estado = '';
    $producto = '';  

    if(
        isset($_POST['fecha1']) &&
        isset($_POST['fecha2']) &&
        isset($_POST['estado1']) && !empty($_POST['estado1'])&&
        isset($_POST['producto1']) && !empty($_POST['producto1'])
    ){
        $fechain = $_POST['fecha1'];
        $fechafin = $_POST['fecha2'];
        $estado = $_POST['estado1'];
        $producto = $_POST['producto1']; 
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


    ####################################################################################

   /* $resultado = $conexion->ejecutarConsulta("
        SELECT a.idpedcab, c.nombre, b.cantidad, a.estado, a.numero_factura, a.fecha_actualizacion, b.subtotal, c.impuesto, c.precio, a.valor_impuesto
        FROM pedidos_cabecera AS a 
        INNER JOIN pedidos_detalle AS b ON (a.idpedcab = b.idpedcab)
        INNER JOIN productos AS c ON (b.idproducto = c.idproducto)
        WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59'
        ORDER BY a.idpedcab DESC
        "); */

    

    if( $estado!='TODO' && $producto!='TODO'){
        $resultado = $conexion->ejecutarConsulta("
        SELECT a.idpedcab, c.nombre, b.cantidad, a.estado, a.numero_factura, a.fecha_actualizacion, b.subtotal, c.impuesto, c.precio, a.valor_impuesto
        FROM pedidos_cabecera AS a 
        INNER JOIN pedidos_detalle AS b ON (a.idpedcab = b.idpedcab)
        INNER JOIN productos AS c ON (b.idproducto = c.idproducto)
        WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59'
        AND a.estado = '".$estado."'
        AND c.idproducto = '".$producto."'
        ORDER BY a.idpedcab DESC
        ");  
    }else{
        
            $resultado = $conexion->ejecutarConsulta("
            SELECT a.idpedcab, c.nombre, b.cantidad, a.estado, a.numero_factura, a.fecha_actualizacion, b.subtotal, c.impuesto, c.precio, a.valor_impuesto
            FROM pedidos_cabecera AS a 
            INNER JOIN pedidos_detalle AS b ON (a.idpedcab = b.idpedcab)
            INNER JOIN productos AS c ON (b.idproducto = c.idproducto)
            WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59'
            ORDER BY a.idpedcab DESC
            ");

            /*if( ($estado!='TODO')){

                $resultado = $conexion->ejecutarConsulta("
                SELECT a.idpedcab, c.nombre, b.cantidad, a.estado, a.numero_factura, a.fecha_actualizacion, b.subtotal, c.impuesto, c.precio, a.valor_impuesto
                FROM pedidos_cabecera AS a 
                INNER JOIN pedidos_detalle AS b ON (a.idpedcab = b.idpedcab)
                INNER JOIN productos AS c ON (b.idproducto = c.idproducto)
                WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59'
                AND a.estado = '".$estado."'
                ORDER BY a.idpedcab DESC
                ");
            }*/
        
            /*if( ($producto!='TODO') ){
                $resultado = $conexion->ejecutarConsulta("
                SELECT a.idpedcab, c.nombre, b.cantidad, a.estado, a.numero_factura, a.fecha_actualizacion, b.subtotal, c.impuesto, c.precio, a.valor_impuesto
                FROM pedidos_cabecera AS a 
                INNER JOIN pedidos_detalle AS b ON (a.idpedcab = b.idpedcab)
                INNER JOIN productos AS c ON (b.idproducto = c.idproducto)
                WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59'
                AND c.idproducto = '".$producto."'
                ORDER BY a.idpedcab DESC
                ");  
            }*/
            
        }

    /*if( ($estado!='TODO')){
        $resultado = $conexion->ejecutarConsulta("
        SELECT a.idpedcab, c.nombre, b.cantidad, a.estado, a.numero_factura, a.fecha_actualizacion, b.subtotal, c.impuesto, c.precio, a.valor_impuesto
        FROM pedidos_cabecera AS a 
        INNER JOIN pedidos_detalle AS b ON (a.idpedcab = b.idpedcab)
        INNER JOIN productos AS c ON (b.idproducto = c.idproducto)
        WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59'
        AND a.estado = '".$estado."'
        ORDER BY a.idpedcab DESC
        ");

        if( ($producto!='TODO') ){
        $resultado = $conexion->ejecutarConsulta("
        SELECT a.idpedcab, c.nombre, b.cantidad, a.estado, a.numero_factura, a.fecha_actualizacion, b.subtotal, c.impuesto, c.precio, a.valor_impuesto
        FROM pedidos_cabecera AS a 
        INNER JOIN pedidos_detalle AS b ON (a.idpedcab = b.idpedcab)
        INNER JOIN productos AS c ON (b.idproducto = c.idproducto)
        WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59'
        AND c.idproducto = '".$producto."'
        ORDER BY a.idpedcab DESC
        ");  
    }
    }*/


    foreach($resultado as $fila){
        $fila['row'] = '';

        $impuesto = ( $fila['impuesto'] == 'SI' ? $parametro['impuesto'] : 0 );
        $fila['valor_impuesto'] = $impuesto;
        $fila['subtotal'] = ( $fila['precio'] * $fila['cantidad'] );
        $valor_impuesto = 0;

        $total = $fila['subtotal'];

        if( (int)$impuesto > 0 ){
            $valor_impuesto = ( $fila['subtotal'] * (int)$impuesto) / 100;
            $total = ( $fila['subtotal'] + $valor_impuesto);
        }

        $fila['impuesto'] = $impuesto;
        $fila['valor_impuesto'] = number_format($valor_impuesto, 2,'.','');
        $fila['precio'] = number_format($fila['precio'], 2,'.','');
        $fila['subtotal'] = number_format($fila['subtotal'], 2,'.','');
        $fila['total'] = number_format($total, 2,'.','');

        $respuesta->total_pedido += $total;
        $respuesta->data[] = $fila;

    }

    $respuesta->total_pedido = number_format($respuesta->total_pedido, 2,'.','');


    


}catch(Exception $e){
    $respuesta->estado = 2;
    $respuesta->mensaje = $e->getMessage();
}

print_r(json_encode($respuesta));