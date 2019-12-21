<?php
include("../system/funciones.php");
include("../system/session.php");
include("../system/conexion.php");
include ("../cabezera_pdf.php");
$conexion = new Conexion('../logs/');
$conexion->conectar();

$session = new Session();

$respuesta = new stdClass();
$respuesta->estado = 1;
$respuesta->mensaje = "";


try{

    if( !$session->checkSession() ) throw new Exception("Debe iniciar una sesión");

        $fechain='';
        $fechafin='';
        $estado='';
        $producto='';

        $fechain = $_POST['fechain'];
        $fechafin = $_POST['fechafin'];
        $estado = $_POST['estado'];
        $producto = $_POST['producto']; 

    

        $pdf = new PDFF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',11);
        //ejecutando la consulta con los parametros recibidos
        
        if( $estado!='TODO' && $producto!='TODO'){
        $resultado = $conexion->ejecutarConsulta("
            SELECT a.idpedcab as aidppecab, c.nombre as cnombre, b.cantidad as bcantidad, a.estado as aestado, a.numero_factura as anumero_factura, a.fecha_actualizacion as afecha_actualizacion, b.subtotal as bsubtotal, c.impuesto as cimpuesto, c.precio as cprecio, a.valor_impuesto as avalor_impuesto
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
            SELECT a.idpedcab as aidppecab, c.nombre as cnombre, b.cantidad as bcantidad, a.estado as aestado, a.numero_factura as anumero_factura, a.fecha_actualizacion as afecha_actualizacion, b.subtotal as bsubtotal, c.impuesto as cimpuesto, c.precio as cprecio, a.valor_impuesto as avalor_impuesto
            FROM pedidos_cabecera AS a 
            INNER JOIN pedidos_detalle AS b ON (a.idpedcab = b.idpedcab)
            INNER JOIN productos AS c ON (b.idproducto = c.idproducto)
            WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59'
            ORDER BY a.idpedcab DESC
            ");
        }
        
        $pdf->Cell(195,10,'Reporte de Ventas',0,1,'C');
        $pdf->Cell(195,10,'Productos: '.$producto,0,1,'L');
        $pdf->Cell(195,10,'Estado: '.$estado,0,1,'L');
        $pdf->Cell(195,10,'Desde: '.$fechain.' hasta: '.$fechafin,0,1,'L');

        $pdf->Cell(5,10,'#',1,0,'C',0);
        $pdf->Cell(25,10,'ID PEDIDO',1,0,'C',0);
        $pdf->Cell(25,10,'PRODUCTO',1,0,'C',0);
        $pdf->Cell(25,10,'CANTIDAD',1,0,'C',0);
        $pdf->Cell(30,10,'ESTADO',1,0,'C',0);
        $pdf->Cell(20,10,utf8_decode('N° PAGO'),1,0,'C',0);
        $pdf->Cell(40,10,'FECHA',1,0,'C',0);
        $pdf->Cell(25,10,'SUBTOTAL',1,1,'C',0);        
        
        $cont = 1;
        $acum = 0; 
        while($row1=$resultado->fetch_assoc()){

            $pdf->Cell(5,10,$cont,1,0,'C',0);
            $pdf->Cell(25,10,$row1['aidppecab'],1,0,'C',0);
            $pdf->Cell(25,10,$row1['cnombre'],1,0,'C',0);
            $pdf->Cell(25,10,$row1['bcantidad'],1,0,'C',0);            
            $pdf->Cell(30,10,$row1['aestado'],1,0,'C',0);
            $pdf->Cell(20,10,$row1['anumero_factura'],1,0,'C',0);
            $pdf->Cell(40,10,$row1['afecha_actualizacion'],1,0,'C',0);
            $pdf->Cell(25,10,$row1['bsubtotal'],1,1,'C',0);
            $acum = $acum + $row1['bsubtotal'];
            $cont++;
        }
        $totalfinal = $acum;
        $pdf->Cell(170,10,'Total',1,0,'C',0);
        $pdf->Cell(25,10,$totalfinal,1,1,'C',0);

        
        $pdf->Output();
    


}catch(Exception $e){
    /*$respuesta->estado = 2;
    $respuesta->mensaje = $e->getMessage();*/
}

print_r(json_encode("hola"));