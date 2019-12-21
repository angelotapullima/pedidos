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

    $idpedcab = 0;

    if(
        isset($_POST['idpedcab']) && !empty($_POST['idpedcab'])
    ){
        //mysqli = new mysqli("localhost","root","","pedidos");
        $idpedcab = $_POST['idpedcab'];
        //$consulta = "select * from pedidos_cabecera where idpedcab='".$idpedcab."'";
        $consulta = "SELECT pc.subtotal as pcsubtotal, pd.impuesto as pdimpuesto, pc.valor_impuesto as pcvalorimpuesto, pc.total as pctotal ,p.idproducto as pidproducto,c.nombre as cnombre, p.precio as pprecio, pd.cantidad as pdcantidad, c.direccion as cdireccion, pc.idpedcab as idpedcab, pc.vendedor, pc.cliente as pccliente, pd.precio, p.nombre as pnombre from clientes c inner join pedidos_cabecera pc on c.documento = pc.cliente inner join pedidos_detalle pd on pd.idpedcab = pc.idpedcab inner JOIN productos p on p.idproducto = pd.idproducto and pc.idpedcab = '".$idpedcab."'";
        /*$consulta = "SELECT pc.idpedcab, pc.vendedor, pc.cliente, c.nombre  from pedidos_cabecera pc inner join clientes c where c.documento = pc.cliente and pc.idpedcab = '".$idpedcab."'";*/
        $resultado = $conexion->ejecutarConsulta($consulta);

        $pdf = new PDFF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        
        /*while($row=$resultado->fetch_assoc()){
            $pdf->Cell(300,15,'Datos del Cliente:',0,1,'L');
            $pdf->Cell(100,10,'Nro Comprobante :  '.$row['idpedcab'] ,0,1,'L',0);            
            $pdf->Cell(100,10,'Nro documento : '.$row['pccliente'],0,1,'L',0);
            $pdf->Cell(100,10,'Nombre : '.$row['cnombre'],0,1,'L',0);            
            $pdf->Cell(100,10,utf8_decode('Direccion :  '.$row['cdireccion']),0,1,'L',0);
            $pdf->Ln();
            $totalfinal = $row['pctotal'];
            break;
        }
        $pdf->Cell(25,10,utf8_decode('Código Prod'),1,0,'C',0);
        $pdf->Cell(35,10,'Producto',1,0,'C',0);
        $pdf->Cell(25,10,'Precio',1,0,'C',0);
        $pdf->Cell(20,10,'Cantidad',1,0,'C',0);
        $pdf->Cell(25,10,'Subtotal',1,0,'C',0);
        $pdf->Cell(20,10,'Impuesto',1,0,'C',0);
        $pdf->Cell(20,10,'Valor Imp',1,0,'C',0);            
        $pdf->Cell(25,10,'Total',1,1,'C',0);*/
        $cont = 0;
        while($row1=$resultado->fetch_assoc()){
            if($cont == 0){
                $pdf->Cell(190,10,'Datos del Cliente:',0,1,'L');
                $pdf->Cell(100,10,'Nro Comprobante :  '.$row1['idpedcab'] ,0,1,'L',0);            
                $pdf->Cell(100,10,'Nro documento : '.$row1['pccliente'],0,1,'L',0);
                $pdf->Cell(100,10,'Nombre : '.$row1['cnombre'],0,1,'L',0);            
                $pdf->Cell(100,10,utf8_decode('Direccion :  '.$row1['cdireccion']),0,1,'L',0);
                $pdf->Ln();
                $pdf->Cell(25,10,utf8_decode('Código Prod'),1,0,'C',0);
                $pdf->Cell(35,10,'Producto',1,0,'C',0);
                $pdf->Cell(25,10,'Precio',1,0,'C',0);
                $pdf->Cell(20,10,'Cantidad',1,0,'C',0);
                $pdf->Cell(25,10,'Impuesto',1,0,'C',0);
                $pdf->Cell(20,10,'Valor Imp',1,0,'C',0);
                $pdf->Cell(20,10,'Subtotal',1,1,'C',0);            
                //$pdf->Cell(25,10,'Total',1,1,'C',0);
            }
            

            $pdf->Cell(25,10,$row1['pidproducto'],1,0,'C',0);
            $pdf->Cell(35,10,$row1['pnombre'],1,0,'C',0);
            $preciop = $row1['pprecio'];
            $pdf->Cell(25,10,$row1['pprecio'],1,0,'C',0);            
            $pdf->Cell(20,10,$row1['pdcantidad'],1,0,'C',0);
            $cantidadp =$row1['pdcantidad'];
            $pdf->Cell(25,10,$row1['pdimpuesto'],1,0,'C',0);
            $pdf->Cell(20,10,$row1['pcvalorimpuesto'],1,0,'C',0);
            $subtotalp = $preciop * $cantidadp;
            //$pdf->Cell(20,10,$row1['pcsubtotal'],1,1,'C',0);
            $pdf->Cell(20,10,$subtotalp,1,1,'C',0);
            //$pdf->Cell(25,10,$row1['pctotal'],1,1,'C',0);
            $totalfinal = $row1['pctotal'];
            $cont++;
        }
        $pdf->Cell(150,10,'Total',1,0,'C',0);
        $pdf->Cell(20,10,$totalfinal,1,0,'C',0);

        /*while($row=$resultado->fetch_assoc()){
            $pdf->Cell(300,15,'Datos del Cliente:',0,1,'L');
            $pdf->Cell(100,10,'Nro Comprobante :  '.$row['idpedcab'] ,0,1,'L',0);            
            $pdf->Cell(100,10,'Nro documento : '.$row['pccliente'],0,1,'L',0);
            $pdf->Cell(100,10,'Nombre : '.$row['cnombre'],0,1,'L',0);            
            $pdf->Cell(100,10,utf8_decode('Direccion :  '.$row['cdireccion']),0,1,'L',0);
            $pdf->Ln();
            $pdf->Cell(25,10,utf8_decode('Código Prod'),1,0,'C',0);
            $pdf->Cell(35,10,'Producto',1,0,'C',0);
            $pdf->Cell(25,10,'Precio',1,0,'C',0);
            $pdf->Cell(20,10,'Cantidad',1,0,'C',0);
            $pdf->Cell(25,10,'Subtotal',1,0,'C',0);
            $pdf->Cell(20,10,'Impuesto',1,0,'C',0);
            $pdf->Cell(20,10,'Valor Imp',1,0,'C',0);            
            $pdf->Cell(25,10,'Total',1,1,'C',0);

            $pdf->Cell(25,10,$row['pidproducto'],1,0,'C',0);
            $pdf->Cell(35,10,$row['pnombre'],1,0,'C',0);
            $pdf->Cell(25,10,$row['pprecio'],1,0,'C',0);            
            $pdf->Cell(20,10,$row['pdcantidad'],1,0,'C',0);
            $pdf->Cell(25,10,$row['pcsubtotal'],1,0,'C',0);
            $pdf->Cell(20,10,$row['pdimpuesto'],1,0,'C',0);
            $pdf->Cell(20,10,$row['pcvalorimpuesto'],1,0,'C',0);
            $pdf->Cell(25,10,$row['pctotal'],1,1,'C',0);

        }*/
        $pdf->Output();
    }

    if( 
        empty($idpedcab) 
    ){
        throw new Exception("No envió el ID del pedido");
    }

    # Actualizar el estado del pedido a facturado

    /*$update = $conexion->ejecutarConsulta("
        UPDATE pedidos_cabecera SET 
        estado='FACTURADO',
        numero_factura='".$idpedcab."',
        usuario_actualizacion='".$_SESSION['usuario']."',
        fecha_actualizacion=NOW()
        WHERE 
        idpedcab = '".$idpedcab."'
    ");

    if( !$update ) throw new Exception("Error al actualizar el pedido");   $respuesta->mensaje = "Pedido # ".$idpedcab.", Impreso con éxito";*/


}catch(Exception $e){
    /*$respuesta->estado = 2;
    $respuesta->mensaje = $e->getMessage();*/
}

print_r(json_encode("hola"));