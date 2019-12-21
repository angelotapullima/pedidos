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

    $existe = 0;
    $documento = '';
    $nombre = '';
    $direccion = '';
    $telefono = '';
    $tipo_documento = '';
    

    if(
        ( isset($_POST['documento']) && !empty($_POST['documento']) ) && 
        ( isset($_POST['nombre']) && !empty($_POST['nombre']) ) && 
        ( isset($_POST['tipo_documento']) && !empty($_POST['tipo_documento']) ) && 
        ( isset($_POST['direccion']) && !empty($_POST['direccion']) ) &&
        ( isset($_POST['telefono']) && !empty($_POST['telefono']) )
    ){
        $documento = $_POST['documento'];
        $nombre = trim($_POST['nombre']);
        $tipo_documento = $_POST['tipo_documento'];
        $direccion = addslashes(trim($_POST['direccion']));
        $telefono = trim($_POST['telefono']);
    }

    if(
        isset($_POST['existe']) && !empty($_POST['existe'])
    ){
        $existe = $_POST['existe'];
    }

    if( empty($documento) || empty($nombre) || empty($tipo_documento) || empty($direccion) || empty($telefono)){
        throw new Exception("Algunos datos llegaron vacios");
    }

    if($tipo_documento=='DNI'){
        if(strlen($documento)!=8){

            throw new Exception("DNI debe contener 8 números");

        }
    }

    if($tipo_documento=='RUC'){
        if(strlen($documento)!=8){

            throw new Exception("RUC debe contener 11 números");

        }
    }


    if( $existe == 1 ){

        $update = $conexion->ejecutarConsulta("
            UPDATE clientes SET
            nombre='".$nombre."',
            tipo_documento='".$tipo_documento."',
            direccion='".$direccion."',
            telefono='".$telefono."',
            usuario_actualizacion='".$_SESSION['usuario']."',
            fecha_actualizacion=NOW()
            WHERE 
            documento = '".$documento."'
        ");

        if( !$update ) throw new Exception("Error al actualizar el Cliente");

        $respuesta->mensaje = "Cliente actualizado con éxito";

    }else{
        $resultado = $conexion->ejecutarConsulta("
            SELECT COUNT(*) AS total 
            FROM clientes
            WHERE documento = '".$documento."'
        ");

        $total = 0;

        foreach($resultado as $fila){
            $total = $fila['total'];
        }

        if( $total > 0 ) throw new Exception("El cliente con N° Documento: (".$documento."), ya existe en la aplicación");

        $insert = $conexion->ejecutarConsulta("
            INSERT INTO clientes
            (documento, nombre, tipo_documento, telefono, direccion, usuario_creacion, fecha_creacion)
            VALUES 
            ('".$documento."','".$nombre."','".$tipo_documento."','".$telefono."','".$direccion."','".$_SESSION['usuario']."',NOW())
        ");

        if( !$insert ) throw new Exception("Error al crear el Cliente");

        $respuesta->mensaje = "Cliente creado con éxito";
    }

}catch(Exception $e){
    $respuesta->estado = 2;
    $respuesta->mensaje = $e->getMessage();
}

print_r(json_encode($respuesta));