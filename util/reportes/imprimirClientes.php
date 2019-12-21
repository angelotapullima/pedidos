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

         
        $fechain = $_POST['fechain'];
        $fechafin = $_POST['fechafin'];
    

        $pdf = new PDFF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        
        $resultado = $conexion->ejecutarConsulta("
        SELECT a.cliente as acliente, b.nombre as bnombre ,SUM(a.total) AS total 
        FROM pedidos_cabecera AS a 
        INNER JOIN clientes AS b ON (a.cliente=b.documento) 
        WHERE a.fecha_actualizacion BETWEEN '".$fechain."' AND '".$fechafin." 23:59:59' 
        AND a.estado='PAGADO' 
        GROUP BY a.cliente 
        ORDER BY total DESC 
        LIMIT 10
        ");
        
        $pdf->Cell(195,10,'Reporte de Clientes Top 10',0,1,'C');
        $pdf->Cell(195,10,'Desde: '.$fechain.' hasta: '.$fechafin,0,1,'L');

        $pdf->Cell(60,10,utf8_decode('N° DOCUMENTO'),1,0,'C',0);
        $pdf->Cell(60,10,'CLIENTE',1,0,'C',0);
        $pdf->Cell(60,10,'TOTAL',1,1,'C',0);

        while($row1=$resultado->fetch_assoc()){
            $pdf->Cell(60,10,$row1['acliente'],1,0,'C',0);
            $pdf->Cell(60,10,$row1['bnombre'],1,0,'C',0);
            $pdf->Cell(60,10,$row1['total'],1,1 ,'C',0);
        }
                
        $pdf->Output();
    


}catch(Exception $e){
    $respuesta->estado = 2;
    $respuesta->mensaje = $e->getMessage();
}

print_r(json_encode("hola"));