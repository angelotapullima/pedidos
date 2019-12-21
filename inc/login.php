<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="lib/css/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="lib/css/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/login.css?v=<?php echo $parametro['webversion']; ?>" rel="stylesheet" type="text/css"/>

    <link rel="icon" type="image/png" href="img/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

    <title>Agua Monte Arroyo</title>
</head>
<body>

<div class="modal fade" id="myModalWarning" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content panel-warning">
					<div class="modal-header panel-heading">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <h4 class="modal-title">Advertencia</h4>
					</div>
					<div class="modal-body text-center" id="myModalWarningBody"></div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				  </div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			  </div><!-- /.modal -->
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="img/logoa.png" alt="IMG">
				</div>

				<form id="formLogin" class="login100-form validate-form">
					<span class="login100-form-title">
						INGRESO AL SISTEMA
					</span>

					<div class="wrap-input100 validate-input" id="formLogin" >
						<input class="input100" type="text" id="usuario" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" >
						<input class="input100" type="password"  id="clave" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div type="submit" class="container-login100-form-btn">
						<button class="login100-form-btn">
							Acceder
						</button>
                    </div>

                    <div class="text-center p-t-136">
						
					</div>

					<!--<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div> -->
				</form>
			</div>
		</div>
	</div>
	

</body>
    <script type="text/javascript" language="javascript" src="lib/js/jquery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="lib/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/select2/select2.min.js"></script>

    <script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>


    <script type="text/javascript" language="javascript" src="js/login.js?v=<?php echo $parametro['webversion']; ?>"></script>
</html>