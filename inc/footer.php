    </div>
    <footer class="main-footer">
   <!-- <div class="pull-right hidden-xs">
      <b>Version 1.0</b>
    </div>-->
    <div class="pull-right hidden-xs">
    <a href="https://api.whatsapp.com/send?phone=+51941805488&text=Hola Soporte técnico, tengo el siguiente problema:" size="5">Soporte Técnico <i class="fa fa-whatsapp"></i></a>
    </div>
    <strong>Copyright &copy; <?php echo date('Y');?> <a style="color: #0F2ECA;" target="_blank">Taller de Software</a>.</strong> Version 1.1
    </footer>
</body>

    <?php

    for($f=0; $f < count($varAcceso['framework']); $f++){
        switch($varAcceso['framework'][$f]){
            case 'jquery';
                echo '<script type="text/javascript" language="javascript" src="lib/js/jquery/jquery-3.3.1.min.js"></script>';
                break;
            case 'bootstrap';
                echo '<script type="text/javascript" language="javascript" src="lib/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>';
                break;
            case 'jquery-treeview';
                echo '<script type="text/javascript" language="javascript" src="lib/js/jquery-treeview-master/jquery.treeview.js"></script>';
                break;
            case 'chosen';
                echo '<script type="text/javascript" language="javascript" src="lib/js/chosen_v1.8.7/chosen.jquery.min.js"></script>';
                break;
            case 'datatables';
                echo '<script type="text/javascript" language="javascript" src="lib/js/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>';
                break;
            case 'highcharts';
                echo '<script type="text/javascript" language="javascript" src="lib/js/Highcharts-7.0.0/code/highcharts.js"></script>';
                echo '<script type="text/javascript" language="javascript" src="lib/js/Highcharts-7.0.0/code/modules/exporting.js"></script>';
                echo '<script type="text/javascript" language="javascript" src="lib/js/Highcharts-7.0.0/code/modules/export-data.js"></script>';
                break;
        }
    }

    ?>
    <script type="text/javascript" language="javascript" src="js/system.js?v=<?php echo $parametro['webversion']; ?>"></script>
    <script type="text/javascript" language="javascript" src="js/<?php echo $pagina; ?>.js?v=<?php echo $parametro['webversion']; ?>"></script>
</html>