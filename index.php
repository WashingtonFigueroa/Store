<?php 
	session_start();
	if(!$_SESSION) {
		header('Location: login/');
	}
?> 
<!DOCTYPE html>
<html ng-app="scotchApp" lang="es">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>DTE | Store1.0</title>
		<meta name="description" content="3 styles with inline editable feature" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
		<link rel="stylesheet" href="dist/css/font-awesome.min.css" />
		<link rel="stylesheet" href="dist/css/style.css" />


		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="dist/css/animate.min.css" />
		<link rel="stylesheet" href="dist/css/jquery.gritter.min.css" />
		<link rel="stylesheet" href="dist/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="dist/css/chosen.min.css" />
		<link rel="stylesheet" href="dist/css/select2.min.css" />
		<link rel="stylesheet" href="dist/css/ui.jqgrid.min.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="dist/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-datetimepicker-standalone.css" />
		<link rel="stylesheet" href="dist/css/bootstrap-editable.min.css" />
		<link rel="stylesheet" href="dist/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="dist/css/sweetalert.css" />

		<link rel="stylesheet" href="dist/css/jquery-ui.custom.min.css" />
		<link href="dist/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
		
		<!-- text fonts -->
		<link rel="stylesheet" href="dist/css/fontdc.css" />
		<!-- ace styles -->
		<link rel="stylesheet" href="dist/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<script src="dist/js/ace-extra.min.js"></script>

		<!-- Angular js -->
		<script src="dist/angular-1.5.0/angular.js"></script>
		<script src="dist/angular-1.5.0/angular-route.js"></script>
		<script src="dist/angular-1.5.0/angular-animate.js"></script>
		<script src="dist/angular-1.5.0/ui-bootstrap-tpls-1.1.2.min.js"></script>
		<script src="dist/angular-1.5.0/angular-resource.js"></script>
		<script src="dist/js/ngStorage.min.js"></script>

		<!-- controlador procesos angular -->
  		<script src="data/app.js"></script>
  		<script src="data/inicio/app.js"></script>
  		<script src="data/empresa/app.js"></script>
  		<script src="data/tipo_ambiente/app.js"></script>
  		<script src="data/tipo_emision/app.js"></script>
  		<script src="data/tipo_comprobante/app.js"></script>
  		<script src="data/tipo_documento/app.js"></script>
  		<script src="data/tipo_producto/app.js"></script>
  		<script src="data/tipo_impuesto/app.js"></script>
  		<script src="data/tarifa_impuesto/app.js"></script>
  		<script src="data/formas_pago/app.js"></script>
  		<script src="data/facturero/app.js"></script>
  		<script src="data/categorias/app.js"></script>
  		<script src="data/marcas/app.js"></script>
  		<script src="data/medida/app.js"></script>
  		<script src="data/bodegas/app.js"></script>
  		<script src="data/clientes/app.js"></script>
  		<script src="data/proveedores/app.js"></script>
  		<script src="data/productos/app.js"></script>
  		<script src="data/inventario/app.js"></script>
  		<script src="data/movimientos/app.js"></script>
  		<script src="data/proformas/app.js"></script>
  		<script src="data/factura_compra/app.js"></script>
  		<script src="data/factura_venta/app.js"></script>
  		<script src="data/validar_facturas/app.js"></script>
  		<script src="data/nota_credito/app.js"></script>
  		<script src="data/ingresos/app.js"></script>
  		<script src="data/egresos/app.js"></script>
  		<script src="data/kardex/app.js"></script>
  		<script src="data/cargos/app.js"></script>
  		<script src="data/usuarios/app.js"></script>
  		<script src="data/privilegios/app.js"></script>
  		<script src="data/cuenta/app.js"></script>
  		<script src="data/reporte_productos/app.js"></script>
  		<script src="data/reporte_compras/app.js"></script>
  		<script src="data/reporte_ventas/app.js"></script>

  		<style type="text/css">
			.control {
				background: #eff3f8;
				/*background: #87b87f;*/
				/*background: #4caf50;*/
				height: 60px;
			}

			.dimensiones {
				margin-top: 13px;
			}

			.posicion{ 
				margin-top: 9px;
				float: right;
				margin-left: -5px;
				margin-right: 10px;
			}

			.menu_superior {
				display: inline-block;
			    font-size: 16px;
			    color: #FFF;
			    text-align: center;
			    width: 20px;
			}
		</style>

		<style type="text/css">
			#tablas .table-bordered>tbody>tr>td{
				padding: 6px !important;
			}
			.ui-jqgrid tr.jqgrow td{
				font-size: 12px;
			}
			.ace-spinner{
				width: 100% !important;
			}
			.loading2 {
			  position: fixed;
			  z-index: 999;
			  height: 2em;
			  width: 2em;
			  overflow: show;
			  margin: auto;
			  top: 0;
			  left: 0;
			  bottom: 0;
			  right: 0;
			}

			/* Transparent Overlay */
			.loading2:before {
			  content: '';
			  display: block;
			  position: fixed;
			  top: 0;
			  left: 0;
			  width: 100%;
			  height: 100%;
			  background-color: rgba(0,0,0,0.7);
			}

			/* :not(:required) hides these rules from IE9 and below */
			.loading2:not(:required) {
			  /* hide "loading2..." text */
			  font: 0/0 a;
			  color: transparent;
			  text-shadow: none;
			  background-color: transparent;
			  border: 0;
			}

			.loading2:not(:required):after {
			  content: '';
			  display: block;
			  font-size: 10px;
			  width: 1em;
			  height: 1em;
			  margin-top: -0.5em;
			  -webkit-animation: spinner 1500ms infinite linear;
			  -moz-animation: spinner 1500ms infinite linear;
			  -ms-animation: spinner 1500ms infinite linear;
			  -o-animation: spinner 1500ms infinite linear;
			  animation: spinner 1500ms infinite linear;
			  border-radius: 0.5em;
			  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
			  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
			}
			@-webkit-keyframes spinner {
			  0% {
			    -webkit-transform: rotate(0deg);
			    -moz-transform: rotate(0deg);
			    -ms-transform: rotate(0deg);
			    -o-transform: rotate(0deg);
			    transform: rotate(0deg);
			  }
			  100% {
			    -webkit-transform: rotate(360deg);
			    -moz-transform: rotate(360deg);
			    -ms-transform: rotate(360deg);
			    -o-transform: rotate(360deg);
			    transform: rotate(360deg);
			  }
			}
			@-moz-keyframes spinner {
			  0% {
			    -webkit-transform: rotate(0deg);
			    -moz-transform: rotate(0deg);
			    -ms-transform: rotate(0deg);
			    -o-transform: rotate(0deg);
			    transform: rotate(0deg);
			  }
			  100% {
			    -webkit-transform: rotate(360deg);
			    -moz-transform: rotate(360deg);
			    -ms-transform: rotate(360deg);
			    -o-transform: rotate(360deg);
			    transform: rotate(360deg);
			  }
			}
			@-o-keyframes spinner {
			  0% {
			    -webkit-transform: rotate(0deg);
			    -moz-transform: rotate(0deg);
			    -ms-transform: rotate(0deg);
			    -o-transform: rotate(0deg);
			    transform: rotate(0deg);
			  }
			  100% {
			    -webkit-transform: rotate(360deg);
			    -moz-transform: rotate(360deg);
			    -ms-transform: rotate(360deg);
			    -o-transform: rotate(360deg);
			    transform: rotate(360deg);
			  }
			}
			@keyframes spinner {
			  0% {
			    -webkit-transform: rotate(0deg);
			    -moz-transform: rotate(0deg);
			    -ms-transform: rotate(0deg);
			    -o-transform: rotate(0deg);
			    transform: rotate(0deg);
			  }
			  100% {
			    -webkit-transform: rotate(360deg);
			    -moz-transform: rotate(360deg);
			    -ms-transform: rotate(360deg);
			    -o-transform: rotate(360deg);
			    transform: rotate(360deg);
			  }
			}
		</style>
	</head>

	<body ng-controller="mainController" class="no-skin">
		<div id="navbar" class="navbar navbar-default navbar-fixed-top" style="background-color: #283149">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
			<div class="navbar-container" id="navbar-container" >
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							DTE Store 1.0
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation" >
					<ul class="nav ace-nav" style="width: : 200px">
						<li class="#404B69">
							<a data-toggle="dropdown" href="" class="dropdown-toggle">
								<img class="nav-user-photo" src=<?php  print_r('data/usuarios/'. $_SESSION['user']['imagen']); ?> alt="" />
								<span class="user-info">
									<small>Bienvenido:</small>
									<?php print_r($_SESSION['user']['name']); ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#/cuenta">
										<i class="ace-icon fa fa-user"></i>
										Mi cuenta
									</a>
								</li>
								<li>
									<a href="#/cargos">
										<i class="menu-icon fa fa-cogs"></i>
										Configuracion
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="login/exit.php">
										<i class="ace-icon fa fa-power-off"></i>
										Salir
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive" >
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<ul class="nav nav-list">
					<li ng-class="{active: $route.current.activetab == 'inicio'}">
						<a href="#/">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Inicio </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'empresa'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-building"></i>
							Empresa
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'empresa'}">
								<a href="#/empresa">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Empresa
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open':
												$route.current.activetab == 'tipo_ambiente' ||
												$route.current.activetab == 'tipo_emision' ||	
												$route.current.activetab == 'tipo_comprobante' ||
												$route.current.activetab == 'tipo_documento' ||
												$route.current.activetab == 'tipo_producto' ||
												$route.current.activetab == 'tipo_impuesto' ||
												$route.current.activetab == 'tarifa_impuesto' ||
												$route.current.activetab == 'formas_pago' ||
												$route.current.activetab == 'facturero' 
												
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-edit"></i>
							Parametros
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'tipo_ambiente'}">
								<a href="#/tipo_ambiente">
									<i class="menu-icon fa fa-caret-right"></i>
									Tipo Ambiente
								</a>

								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'tipo_emision'}">
								<a href="#/tipo_emision">
									<i class="menu-icon fa fa-caret-right"></i>
									Tipo Emisión
								</a>

								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'tipo_comprobante'}">
								<a href="#/tipo_comprobante">
									<i class="menu-icon fa fa-caret-right"></i>
									Tipo Comprobante
								</a>

								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'tipo_documento'}">
								<a href="#/tipo_documento">
									<i class="menu-icon fa fa-caret-right"></i>
									Tipo Documento
								</a>

								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'tipo_producto'}">
								<a href="#/tipo_producto">
									<i class="menu-icon fa fa-caret-right"></i>
									Tipo Producto
								</a>

								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'tipo_impuesto'}">
								<a href="#/tipo_impuesto">
									<i class="menu-icon fa fa-caret-right"></i>
									Tipo Impuesto
								</a>

								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'tarifa_impuesto'}">
								<a href="#/tarifa_impuesto">
									<i class="menu-icon fa fa-caret-right"></i>
									Tarifa Impuesto
								</a>

								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'formas_pago'}">
								<a href="#/formas_pago">
									<i class="menu-icon fa fa-caret-right"></i>
									Formas Pago
								</a>

								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'facturero'}">
								<a href="#/facturero">
									<i class="menu-icon fa fa-caret-right"></i>
									Ingreso Facturero
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'categorias' ||
												$route.current.activetab == 'marcas' ||
												$route.current.activetab == 'bodegas'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-cogs"></i>
							Generales
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'categorias'}">
								<a href="#/categorias">
									<i class="menu-icon fa fa-caret-right"></i>
									Categorias
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'marcas'}">
								<a href="#/marcas">
									<i class="menu-icon fa fa-caret-right"></i>
									Marcas
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'bodegas'}">
								<a href="#/bodegas">
									<i class="menu-icon fa fa-caret-right"></i>
									Bodegas
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'clientes' ||
												$route.current.activetab == 'proveedores' ||
												$route.current.activetab == 'productos' 
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Ingresos
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'clientes'}">
								<a href="#/clientes">
									<i class="menu-icon fa fa-caret-right"></i>
									Clientes
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'proveedores'}">
								<a href="#/proveedores">
									<i class="menu-icon fa fa-caret-right"></i>
									Proveedores
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'productos'}">
								<a href="#/productos">
									<i class="menu-icon fa fa-caret-right"></i>
									Productos
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'inventario' ||
												$route.current.activetab == 'movimientos'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-files-o"></i>
							Inventario
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'inventario'}">
								<a href="#/inventario">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Inventario
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'movimientos'}">
								<a href="#/movimientos">
									<i class="menu-icon fa fa-caret-right"></i>
									Movimientos
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'proformas'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-shopping-cart"></i>
							<span class="menu-text">
								Proformas
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'proformas'}">
								<a href="#/proformas">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Proforma
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'factura_compra' ||
												$route.current.activetab == 'devolucion_compra'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-shopping-cart"></i>
							<span class="menu-text">
								Factura Compra
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'factura_compra'}">
								<a href="#/factura_compra">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Factura Compra
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'factura_venta' ||
												$route.current.activetab == 'validar_facturas'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-shopping-cart"></i>
							<span class="menu-text">
								Factura Venta
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'factura_venta'}">
								<a href="#/factura_venta">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Factura Venta
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'validar_facturas'}">
								<a href="#/validar_facturas">
									<i class="menu-icon fa fa-caret-right"></i>
									Validar Facturas Venta
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'nota_credito' ||
												$route.current.activetab == 'validar_nota_credito'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-shopping-cart"></i>
							<span class="menu-text">
								Nota Crédito
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'nota_credito'}">
								<a href="#/nota_credito">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Nota Crédito
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'ingresos' ||
												$route.current.activetab == 'egresos'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-folder-open-o"></i>
							<span class="menu-text">
								Transacciones
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'ingresos'}">
								<a href="#/ingresos">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Ingreso
								</a>
							</li>

							<li ng-class="{active: $route.current.activetab == 'egresos'}">
								<a href="#/egresos">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Egreso
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li ng-class = "{'active open': 
												$route.current.activetab == 'kardex'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-paperclip"></i>
							Kardex
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">

							<li ng-class="{active: $route.current.activetab == 'kardex'}">
								<a href="#/kardex">
									<i class="menu-icon fa fa-caret-right"></i>
									Consultar Kardex
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<!-- <li ng-class = "{'active open': 
												$route.current.activetab == 'cargos' ||
												$route.current.activetab == 'usuarios' ||
												$route.current.activetab == 'privilegios' 
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							Usuarios
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'cargos'}">
								<a href="#/cargos">
									<i class="menu-icon fa fa-caret-right"></i>
									Perfiles
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'usuarios'}">
								<a href="#/usuarios">
									<i class="menu-icon fa fa-caret-right"></i>
									Registro Usuario
								</a>
								<b class="arrow"></b>
							</li>

							<li ng-class="{active: $route.current.activetab == 'privilegios'}">
								<a href="#/privilegios">
									<i class="menu-icon fa fa-caret-right"></i>
									Privilegios
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li> -->

					<li ng-class = "{'active open':
												$route.current.activetab == 'reporte_productos' ||
												$route.current.activetab == 'reporte_compras' ||
												$route.current.activetab == 'reporte_ventas'
									}">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-archive"></i>
							<span class="menu-text">
								Reportes
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li ng-class="{active: $route.current.activetab == 'reporte_productos'}">
								<a href="#/reporte_productos">
									<i class="menu-icon fa fa-file-pdf-o red2"></i>
									Reporte Productos
								</a>
							</li>

							<li ng-class="{active: $route.current.activetab == 'reporte_compras'}">
								<a href="#/reporte_compras">
									<i class="menu-icon fa fa-file-pdf-o red2"></i>
									Reporte Compras
								</a>
							</li>

							<li ng-class="{active: $route.current.activetab == 'reporte_ventas'}">
								<a href="#/reporte_ventas">
									<i class="menu-icon fa fa-file-pdf-o red2"></i>
									Reporte Ventas
								</a>
							</li>

							<!-- <li class="">
								<a href="#/reporte_proformas">
									<i class="menu-icon fa fa-calendar"></i>
									Reporte Proformas
								</a>
							</li> -->
						</ul>
					</li>
				</ul>

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<div class="main-content ng-view" id="main-container"></div>

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							Applicación &copy; 2017-2018
						</span>
					</div>
				</div>
			</div>

			<a href="" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>

		<script type="text/javascript">
			window.jQuery || document.write("<script src='dist/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<script src="dist/js/jquery-ui.min.js"></script>
		<script src="dist/js/jquery.ui.touch-punch.min.js"></script>
		<script src="dist/js/jquery.easypiechart.min.js"></script>
		<script src="dist/js/jquery.sparkline.min.js"></script>
		<script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
    	<script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script>

		<script src="dist/js/fileinput.js" type="text/javascript"></script>
		<script src="dist/js/bootstrap.min.js"></script>
		<script src="dist/js/jquery.form.js"></script>
		<script src="dist/js/chosen.jquery.min.js"></script>

		<script src="dist/js/jquery.validate.min.js"></script>
		<script src="dist/js/jquery.gritter.min.js"></script>
		<script src="dist/js/bootbox.min.js"></script>
		<script src="dist/js/fuelux/fuelux.wizard.min.js"></script>
		<script src="dist/js/additional-methods.min.js"></script>
		
		<script src="dist/js/jquery.hotkeys.min.js"></script>
		<script src="dist/js/bootstrap-wysiwyg.min.js"></script>
		<script src="dist/js/select2.min.js"></script>
		<script src="dist/js/fuelux/fuelux.spinner.min.js"></script>
		<script src="dist/js/fuelux/fuelux.tree.min.js"></script>
		<script src="dist/js/x-editable/bootstrap-editable.min.js"></script>
		<script src="dist/js/x-editable/ace-editable.min.js"></script>
		<script src="dist/js/jquery.maskedinput.min.js"></script>
		<script src="dist/js/bootbox.min.js"></script>
		<script src="dist/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="dist/js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="dist/js/date-time/moment.min.js"></script>
		<script src="dist/js/date-time/daterangepicker.min.js"></script>
		<script src="dist/js/date-time/bootstrap-datetimepicker.min.js"></script>
		
		<!-- script de las tablas -->
		<script src="dist/js/jqGrid/jquery.jqGrid.min.js"></script>
		<script src="dist/js/jqGrid/i18n/grid.locale-en.js"></script>
		<script src="dist/js/dataTables/jquery.dataTables.min.js"></script>
		<script src="dist/js/dataTables/jquery.dataTables.bootstrap.min.js"></script>
		<script src="dist/js/dataTables/dataTables.tableTools.min.js"></script>
		<script src="dist/js/dataTables/dataTables.colVis.min.js"></script>

		<!-- ace scripts -->
		<script src="dist/js/ace-elements.min.js"></script>
		<script src="dist/js/ace.min.js"></script>
		<script src="dist/js/lockr.min.js"></script>
		<script src="dist/js/sweetalert.min.js"></script>
		<script src="dist/js/jquery.blockUI.js"></script>	
	</body>
</html>
