<h1><?php echo $varAcceso['nombre']; ?></h1>
<ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="#home">Ventas</a></li>
    <li><a data-toggle="tab" href="#menu1">Clientes</a></li>
</ul>
<div class="tab-content">
    <div id="home" class="row tab-pane fade in active">
        <br>
        
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo_estado"> Fecha Inicio</label>
                        <input type="date" id="fecha_ini" class="form-control" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                     <label for="tipo_estado"> Fecha Fin</label>
                        <input type="date" id="fecha_fin" class="form-control" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo_estado"> Estado</label>
                        <select id="tipo_estado" class="form-control">
                            <option value="TODO" selected="selected">Todo</option>
                            <option value="CREADO">Creado</option>
                            <option value="PAGADO">Pagado</option>
                            <option value="CANCELADO">Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo_producto"> Producto</label>
                        <select id="tipo_producto" class="form-control">
                            <option value="Todo" selected="selected">Todo</option>
                            <?php for($f = 0; $f < count($vectorProducto); $f++ ){ ?>
                                <option value="<?php echo $vectorProducto[$f]['idproducto']; ?>"><?php echo $vectorProducto[$f]['nombre']; ?></option>
                            <?php } ?>
                        
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <button type="submit" class="btn btn-block btn-primary" id="consultar">Consultar</button>
                </div>
                <div class="col-md-6 form-group">
                    <button type="submit" class="btn btn-block btn-success" id="imprimir">Imprimir</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="cargando" class="text-center"></div>
                </div>
                <div id="cntTabla" class="col-md-12">
                    <div class="table-responsive">
                        <table id="tablaPedidos" class="table cell-border stripe display" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID PEDIDO</th>
                                    <th>PRODUCTO</th>
                                    <th>CANTIDAD</th>
                                    <th>ESTADO</th>
                                    <th>N° PAGO</th>
                                    <th>FECHA</th>
                                    <th>SUB TOTAL</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                      <div class="col-md-2 pull-right">
                                <label for="Total">TOTAL</label>
                                <input type="text" id="total"class="form-control" readonly="readonly">
                        </div>  
            </div>
        </div>
    </div>

    <div id="menu1" class="row tab-pane fade">
    <br>
    <h1></h1>
    <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo_estado"> Fecha Inicio</label>
                        <input type="date" id="fecha_ini1" class="form-control" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                     <label for="tipo_estado"> Fecha Fin</label>
                        <input type="date" id="fecha_fin2" class="form-control" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="item"> ITEM</label>
                        <select id="item" class="form-control">
                            <option value="1" selected="selected">TOP 10</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <button type="submit" class="btn btn-block btn-primary" id="ReporteCliente">Consultar</button>
                </div>
                <div class="col-md-6 form-group">
                    <button type="submit" class="btn btn-block btn-success" id="imprimir1">Imprimir</button>
                </div>
            </div>
            <br>
            <div id="reporte_cliente" class="col-md-12">
                <input type="text"id="opc"value="casa" style="visibility: hidden">
            </div>
        </div>
    </div>