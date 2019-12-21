<?php

require 'dfg.php';
$pdf = new PDFF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
$NOMBRE = $_POST['nombre'];
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'Datos del Cliente:' ,0,1,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(100,6,'Nombre : ' ,0,1,'L',0);
$pdf->Cell(100,6,'Dni :  ' ,0,1,'L',0);
$pdf->Cell(100,6,'Dirección :  ',0,1,'L',0);
$pdf->Ln();

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'Datos de Productos:' ,0,1,'c',0);
$pdf->Cell(45,10,'Producto',1,0,'c',0);
$pdf->Cell(45,10,'Cantidad',1,0,'c',0);
$pdf->Cell(45,10,'Precio',1,0,'c',0);
$pdf->Cell(45,10,$NOMBRE,1,0,'c',0);

//foreach ($detalle_ventas as $m){

    //$valor= $m->venta_cantidad * $m->venta_precio_parcial;

   // $producto= $this->venta->listar_producto_por_id_producto($m->id_producto);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190,10,'' ,0,1,'c',0);
    $pdf->Cell(45,10,'PRODUCCTO',1,0,'c',0);
    $pdf->Cell(45,10,'Venta',1,0,'c',0);
    $pdf->Cell(45,10,'venta2',1,0,'c',0);
    $pdf->Cell(45,10,'valor',1,0,'c',0);
//}

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'' ,0,1,'c',0);
$pdf->Cell(135,10,"total",1,0,'c',0);
$pdf->Cell(45,10,'total',1,0,'c',0);


$pdf->Output();