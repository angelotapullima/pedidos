function mostrarDetalle(fechain, fechafin, estado, producto){
        var fecha1 =fechain;
        var fecha2 =fechafin;
        var estado1 =estado;
        var producto1 =producto;
        //console.log(fecha1);
        $.ajax({
            type: "POST",
            url: "util/reportes/queryReportes.php",
            data: {
                fecha1:fecha1,
                fecha2:fecha2,
                estado1:estado1,
                producto1:producto1
            },
            dataType: 'json',
            beforeSend: function(){
                $("#detalleCarrito").html('<tr><td colspan="20" class="text-center"><img src="img/system/cargando.gif" height="70" width="70"></td></tr>');
            },
            error: function(request, status, error){
                alert(request.responseText);
            },
            success: function(respuesta){
                switch(respuesta.estado){
                    case 1:                
                        //console.log(respuesta);
                        $("#cargando").html('');
            $("#cntTabla").show();

            var mydata = respuesta.data;
            //console.log(respuesta.total_pedido);

            $("#total").val(respuesta.total_pedido);
            
            var t = $("#tablaPedidos").DataTable({
                destroy: true,
                data: mydata,
                columns: [
                    {"data":'row'},
                    {"data":'idpedcab', className: "text-center"},
                    {"data":'nombre', className: "text-center"},
                    {"data":'cantidad', className: "text-left"},
                    {"data":'estado', className: "text-left"},
                    {"data":'numero_factura', className: "text-center"},
                    {"data":'fecha_actualizacion', className: "text-center"},
                    {"data":'subtotal', className: "text-right"}
                ],
                "columnDefs": [
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": [0] // Para que el numero no tenga orden solo es un indice
                    }
                ],
                "order": [[0, 'asc']], // asc - desc
                "language":{
                    "url":"lib/js/DataTables/DataTables-1.10.18/Spanish.json"
                },
                "pagingType": "full_numbers" // Para colocar el First & Last
            });

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
    
                        break;
                    case 2:
                        $('#myModalWarningBody').html(respuesta.mensaje);
                        $('#myModalWarning').modal('show');
                        console.log(respuesta);           
                        break;
                    default:
                        alert("Se ha producido un error");
                        break;
                }
            }
        });

    
}
var num=0;
function mostrarClientes(fechain, fechafin){
    var fecha1 = fechain;
    var fecha2 = fechafin;
    //console.log(fechain2);


    $.ajax({
        type: "POST",
        url: "util/reportes/top10.php",
        data: {
            fecha1:fecha1,
            fecha2:fecha2
        },
        dataType: 'json',
        /*beforeSend: function(){
            $("#reporte_cliente").html('<tr><td colspan="20" class="text-center"><img src="img/system/cargando.gif" height="70" width="70"></td></tr>');
        },*/
        error: function(request, status, error){
            alert(request.responseText);
        },
        success: function(respuesta){
            switch(respuesta.estado){
                case 1:                
                    //console.log(respuesta);
                    var detalle = respuesta.data;
                    var cuerpoDetalle = '';
                    var uno='1';
                    var dos='2';
                    

                    $("#reporte_cliente").html('<div class="col-md-12 text-center"><img src="img/system/cargando.gif" height="70" width="70"></div>');

                    var pedido_detalle = '';

                    ////////////////////////////////////////////////////////

                    pedido_detalle += '<div class="row">';
                    pedido_detalle += '<div class="col-md-12">';
                    pedido_detalle += '<div class="table-responsive">';

                    pedido_detalle += '<table class="table table-striped table-bordered display" width="100%">';

                    pedido_detalle += '<thead>';
                    pedido_detalle += '<tr>';
                    pedido_detalle += '<th>N° DOCUMENTO</th>';
                    pedido_detalle += '<th>CLIENTE</th>';
                    pedido_detalle += '<th>TOTAL</th>';
                    pedido_detalle += '</tr>';
                    pedido_detalle += '</thead>';
                    pedido_detalle += '<tbody>';
                   

                    if( detalle.length > 0 ){
                        $("#opc").val('1');
                        num=1;
                        for(var f = 0; f < detalle.length; f++){
                            pedido_detalle += '<tr>';
                            pedido_detalle += '<td class="text-center">'+detalle[f]['cliente']+'</td>';
                            pedido_detalle += '<td class="text-left">'+detalle[f]['nombre']+'</td>';
                            pedido_detalle += '<td class="text-right">'+detalle[f]['total']+'</td>';
                            pedido_detalle += '</tr>';
                        }

                    }else{
                        num=2;
                        $("#opc").val('2');
                        pedido_detalle += '<tr>';
                        pedido_detalle += '<td colspan="20" class="text-center">SIN DATOS</td>';
                        pedido_detalle += '</tr>';
                    }

                    pedido_detalle += '</tbody>';
                    pedido_detalle += '</table>';
                    pedido_detalle += '</div>';
                    pedido_detalle += '</div>';
                    pedido_detalle += '</div>';

                    $("#reporte_cliente").html(pedido_detalle);

                    break;
                case 2:
                    $('#myModalWarningBody').html(respuesta.mensaje);
                    $('#myModalWarning').modal('show');            
                    break;
                default:
                    alert("Se ha producido un error");
                    break;
            }
        }
    });
}

$(document).ready(function (){

    $("#consultar").click(function (){
        var fechain = $("#fecha_ini").val();
        var fechafin = $("#fecha_fin").val();
        var estado = $("#tipo_estado option:selected").val();
        var producto = $("#tipo_producto option:selected").val();

        mostrarDetalle(fechain, fechafin, estado, producto);
    });

    $("#imprimir").click(function (){

        var total = $("#total").val();

        if( total != '' ){
            //$('#myModalProductos').modal('show');
            var fechain = $("#fecha_ini").val();
            var fechafin = $("#fecha_fin").val();
            var estado = $("#tipo_estado option:selected").val();
            var producto = $("#tipo_producto option:selected").val();

                $.ajax({
                asyn: false,
                type: "POST",
                url: "util/reportes/imprimirReporte.php",
                data: {
                    fechain:fechain,
                    fechafin:fechafin,
                    estado:estado,
                    producto:producto
                },
                dataType: 'json',
                //beforeSend: function(){},
                error: function(request, status, error){
                    alert(request.responseText);
                },
                success: function(respuesta){
                    switch(respuesta.estado){
                        case 1:
                            $('#myModalSuccessBody').html(respuesta.mensaje);
                            $('#myModalSuccess').modal('show');
                            break;
                        case 2:
                            $('#myModalWarningBody').html(respuesta.mensaje);
                            $('#myModalWarning').modal('show');            
                            break;
                        default:
                            alert("Se ha producido un error");
                            break;
                    }
                },
                /*complete: function(){
                    mostrarDatosPedidos();
                }*/
            });
        }else{
            $('#myModalWarningBody').html("Antes debe oprimir 'Consultar'");
            $('#myModalWarning').modal('show');   
        }
    });

    $("#ReporteCliente").click(function (){
        var fechain = $("#fecha_ini1").val();
        var fechafin = $("#fecha_fin2").val();
        var item = $("#item option:selected").val();
        //console.log(fechain);

        if(item='1'){

            mostrarClientes(fechain, fechafin);
        }
    });

    $("#imprimir1").click(function (){

        var fechain = $("#fecha_ini1").val();
        var fechafin = $("#fecha_fin2").val();

        var opc = $("#opc").val();

        if( num == 1 ){
                $.ajax({
                asyn: false,
                type: "POST",
                url: "util/reportes/imprimirClientes.php",
                data: {
                    fechain:fechain,
                    fechafin:fechafin
                },
                dataType: 'json',
                //beforeSend: function(){},
                error: function(request, status, error){
                    alert(request.responseText);
                },
                success: function(respuesta){
                    switch(respuesta.estado){
                        case 1:
                            $('#myModalSuccessBody').html(respuesta.mensaje);
                            $('#myModalSuccess').modal('show');
                            break;
                        case 2:
                            $('#myModalWarningBody').html(respuesta.mensaje);
                            $('#myModalWarning').modal('show');            
                            break;
                        default:
                            alert("Se ha producido un error");
                            break;
                    }
                },
                /*complete: function(){
                    mostrarDatosPedidos();
                }*/
            });
        }else{
           
            $('#myModalWarningBody').html("Antes debe oprimir 'Consultar'");
            $('#myModalWarning').modal('show');   
        }
            
    });


});