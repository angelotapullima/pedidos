function mostrarDatos(){

    $.ajax({
        //async: true,
        type: "POST",
        url: "util/clientes/query.php",
        //data: {},
        dataType: 'json',
        beforeSend: function(){
            $("#cntTabla").hide();
            $("#cargando").html('<img src="img/system/cargando.gif" height="70" width="70">');
        },
        error: function(request, status, error){
            alert(request.responseText);
        },
        success: function(respuesta){
            $("#cargando").html('');
            $("#cntTabla").show();

            var mydata = respuesta.data;
            
            var t = $("#tablaClientes").DataTable({
                destroy: true,
                data: mydata,
                columns: [
                    {"data":'row'},
                    {"data":'btn_gestion', className: "text-center"},
                    {"data":'documento', className: "text-center"},
                    {"data":'nombre', className: "text-center"},
                    {"data":'telefono', className: "text-center"},
                    {"data":'direccion', className: "text-center"}
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
        },
        //complete: function(){}
    });

}

function limpiarFormUsuario(){
    $('#formClientes').trigger("reset");
    $("#documento").prop('disabled', false);
}

$(document).ready(function (){

    mostrarDatos();

    $("#limpiarformCliente").click(function (){
        limpiarFormUsuario();
    });

    $("#consultar").click(function (){
        limpiarFormUsuario();
        mostrarDatos();
    });

    $("#tablaClientes").on("click",".gestion_update", function(event){
        var tableInt = $("#tablaClientes").DataTable();
        var datos = tableInt.row( $(this).closest('tr') ).data();
        //console.log(datos);
        $("#documento").prop('disabled', true);
        $("#documento").val(datos['documento']);
        $("#cliente").val(datos['nombre']);
        $("#telefono").val(datos['telefono']);
        $("#direccion").val(datos['direccion']);
        $('#tipo_documento option[value="'+datos['tipo_documento']+'"]').prop("selected", true);

        $('.nav-tabs a[href="#menu1"]').tab('show');
    });

    $("#formClientes").submit(function (){
        var existe = ( $("#documento").is(":disabled") ? 1 : 0 );
        var documento = $("#documento").val().toLowerCase();
        var nombre = $("#cliente").val();
        var direccion = $("#direccion").val();
        var telefono = $("#telefono").val();
        var tipo_documento = $("#tipo_documento option:selected").val();

        $.ajax({
            async: false,
            type: "POST",
            url: "util/clientes/gestion.php",
            data: {
                existe:existe,
                documento: documento,
                nombre: nombre,
                direccion: direccion,
                telefono: telefono,
                tipo_documento:tipo_documento
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

                        $('.nav-tabs a[href="#home"]').tab('show');
                        mostrarDatos();
                        limpiarFormUsuario();
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
            //complete: function(){}
        });

        return false;
    });

});