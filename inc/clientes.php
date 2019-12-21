<h1><?php echo $varAcceso['nombre']; ?></h1>
<ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="=#home">Visualizar</a></li>
    <li><a data-toggle="tab" href="#menu1">Gestión</a></li>
</ul>
<div class="tab-content">
    <div id="home" class="row tab-pane fade in active">
        <div class="col-md-12">
            <div class="row page-header">
                <div class="col-md-12 form-group">
                    <button type="button" class="btn btn-block btn-primary" id="consultar">Consultar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="cargando" class="text-center"></div>
                </div>
                <div id="cntTabla" class="col-md-12">
                    <div class="table-responsive">
                        <table id="tablaClientes" class="table cell-border stripe display" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>GESTION</th>
                                    <th>N° DOCUMENTO</th>
                                    <th>CLIENTE</th>
                                    <th>TELEFONO</th>
                                    <th>DIRECCION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="menu1" class="row tab-pane fade">
        <br>
        <div class="col-md-12">
        <div class="alert alert-warning alert-dismissable">
                <ul>
                    <li>(*) Campos obligatorios</li>
                </ul>
            </div>
            <form role="form" id="formClientes">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cliente"> Nombre Cliente / Razón Social (*)</label>
                            <input type="text" id="cliente" maxlength="100" class="form-control" require>
                        </div>
                        <div class="form-group">
                            <label for="documento"> N° Documento (*)</label>
                            <input type="text" onkeypress="return solonumeros(event);" id="documento" minlength="8" maxlength="11" class="form-control" require>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="tipo_documento"> Tipo documento</label>
                        <select id="tipo_documento" class="form-control">
                            <option value="DNI" selected="selected">DNI</option>
                            <option value="RUC">RUC</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="telefono"> Teléfono</label>
                            <input type="text" onkeypress="return solonumeros(event);" id="telefono" minlength="9" maxlength="9" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="direccion"> Dirección</label>
                            <input type="text" id="direccion" maxlength="100" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <button type="reset" id="limpiarformCliente" class="btn btn-block btn-info">Nuevo</button>
                    </div>
                    <div class="col-md-6 form-group">
                        <button type="submit" id="formCliente" class="btn btn-block btn-success" >Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
        function solonumeros(e){
            var key = window.Event ? e.which : e.keyCode 
            return (key >= 48 && key <= 57)
        }
</script>
