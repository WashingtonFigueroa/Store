<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	$fecha = $class->fecha_hora();

	// modificar privilegios
	if (isset($_POST['updateprivilegios'])) {
		$vector = json_encode($_POST['data']);
		$data = 0;

		$resp = $class->consulta("UPDATE privilegios SET data = '$vector' WHERE id_usuario = '$_POST[user]'");
		if ($resp) {
			$data = 1;
		} 

		echo $data;
	}
	// fin

	//LLena combo usuarios
	if (isset($_POST['llenar_usuarios'])) {
		$id = $class->idz();
		$resultado = $class->consulta("SELECT * FROM usuarios WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			print '<option value="'.$row['id'].'">'.$row['nombres_completos'].'</option>';
		}
	}
	// fin

	// estado privilegios
	function buscarstatus($array, $valor) {
		$retorno = array_search($valor, $array);
		if ($retorno) {
			return true;
		} else {
			return false;
		}	
	}
	// fin

	// Inicios methodo recursos data
	if (isset($_POST['retornar'])) {
		$sum;
		$result = $class->consulta("SELECT * FROM privilegios WHERE id_usuario = '".$_POST['id']."'");
		while ($row = $class->fetch_array($result)) {
			$sum = json_decode($row['data']);
		}

		$acumulador = 
		array(
			'Empresa' => 
				array(
				'text' => 'Empresa',
				'type' => 'folder',
				'additionalParameters' => 
					array(
						'id' => 1,
						'children' => 
						array(
							'RegistroEmpresa'=> 
							array(
								'text' => 'Registro Empresa', 
								'type' => 'item',
								'id' => 'empresa',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'empresa')
								)
							)									
						)
					)
				),
			'Parametros' => 
				array(
				'text' => 'Parametros',
				'type' => 'folder',
				'additionalParameters' => 
					array(
						'id' => 1,
						'children' => 
						array(
							'TipoAmbiente'=> 
							array(
								'text' => 'Tipo Ambiente', 
								'type' => 'item',
								'id' => 'tipo_ambiente',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tipo_ambiente')
								)
							),
							'TipoEmision'=> 
							array(
								'text' => 'Tipo Emisión', 
								'type' => 'item',
								'id' => 'tipo_emision',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tipo_emision')
								)
							),
							'TipoComprobante'=> 
							array(
								'text' => 'Tipo Comprobante', 
								'type' => 'item',
								'id' => 'tipo_comprobante',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tipo_comprobante')
								)
							),
							'TipoDocumento'=> 
							array(
								'text' => 'Tipo Documento', 
								'type' => 'item',
								'id' => 'tipo_documento',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tipo_documento')
								)
							),
							'TipoProducto'=> 
							array(
								'text' => 'Tipo Producto', 
								'type' => 'item',
								'id' => 'tipo_producto',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tipo_producto')
								)
							),
							'TipoImpuesto'=> 
							array(
								'text' => 'Tipo Impuesto', 
								'type' => 'item',
								'id' => 'tipo_impuesto',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tipo_impuesto')
								)
							),
							'TipoRetencion'=> 
							array(
								'text' => 'Tipo Retención', 
								'type' => 'item',
								'id' => 'tipo_impuesto',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tipo_impuesto')
								)
							),
							'TarifaImpuesto'=> 
							array(
								'text' => 'Tarifa Impuesto', 
								'type' => 'item',
								'id' => 'tarifa_impuesto',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tarifa_impuesto')
								)
							),
							'TarifaRetencion'=> 
							array(
								'text' => 'Tarifa Retención', 
								'type' => 'item',
								'id' => 'tarifa_retencion',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'tarifa_retencion')
								)
							),
							'FormasPago'=> 
							array(
								'text' => 'Formas Pago', 
								'type' => 'item',
								'id' => 'formas_pago',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'formas_pago')
								)
							),
							'Ingreso Facturero'=> 
							array(
								'text' => 'IngresoFacturero', 
								'type' => 'item',
								'id' => 'facturero',
								'additionalParameters' => 
								array(
									'id' => '101',
									'item-selected' => buscarstatus($sum,'facturero')
								)
							)
						)
					)
				),
			'Generales' => 
				array(
				'text' => 'Generales',
				'type' => 'folder',
				'additionalParameters' => 
					array(
					'id' => 1,
					'children' => 
						array(
						'Categorias'=> 
							array(
								'text' => 'Categorias', 
								'type' => 'item',
								'id' => 'categorias',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'categorias')
								)
							),
							'Marcas'=> 
							array(
								'text' => 'Marcas', 
								'type' => 'item',
								'id' => 'marcas',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'marcas')
								)
							),
							'Presentacion'=> 
							array(
								'text' => 'Presentacion', 
								'type' => 'item',
								'id' => 'medida',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'medida')
								)
							),
							'Almacenes'=> 
							array(
								'text' => 'Almacenes', 
								'type' => 'item',
								'id' => 'bodegas',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'bodegas')
								)
							)
						)
					)
				),
			'Ingresos' => 
				array(
				'text' => 'Ingresos',
				'type' => 'folder',
				'additionalParameters' => 
					array(
					'id' => 1,
					'children' => 
						array(
						'Clientes'=> 
							array(
								'text' => 'Clientes', 
								'type' => 'item',
								'id' => 'clientes',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'clientes')
								)
							),
							'Proveedores'=> 
							array(
								'text' => 'Proveedores', 
								'type' => 'item',
								'id' => 'proveedores',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'proveedores')
								)
							),
							'Productos'=> 
							array(
								'text' => 'Productos', 
								'type' => 'item',
								'id' => 'productos',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'productos')
								)
							)
						)
					)
				),
			'Importar' => 
				array(
				'text' => 'Importar',
				'type' => 'folder',
				'additionalParameters' => 
					array(
					'id' => 1,
					'children' => 
						array(
							'ImportarCSV'=> 
							array(
								'text' => 'Importar CSV', 
								'type' => 'item',
								'id' => 'importar',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'importar')
								)
							)
						)
					)
				),
			'Inventario' => 
				array(
				'text' => 'Inventario',
				'type' => 'folder',
				'additionalParameters' => 
					array(
					'id' => 1,
					'children' => 
						array(
						'RegistroInventario'=> 
							array(
								'text' => 'Registro Inventario', 
								'type' => 'item',
								'id' => 'inventario',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'inventario')
								)
							),
							'Movimientos'=> 
							array(
								'text' => 'Movimientos', 
								'type' => 'item',
								'id' => 'movimientos',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'movimientos')
								)
							)
						)
					)
				),
			'Proformas' => 
				array(
				'text' => 'Proformas',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
					array(
						'RegistroProfroma'=> 
							array(
								'text' => 'Registro Proforma', 
								'type' => 'item',
								'id' => 'proformas',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'proformas')
								)
							),
						)
					)
				),
			'FacturaCompra' => 
				array(
				'text' => 'Factura Compra',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'RegistroFactura'=> 
							array(
								'text' => 'Registro Factura', 
								'type' => 'item',
								'id' => 'factura_compra',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'factura_compra')
								)
							),
							'DevolucionCompra'=> 
							array(
								'text' => 'Devolución Compra', 
								'type' => 'item',
								'id' => 'devolucion_compra',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'devolucion_compra')
								)
							)
						)
					)
				),
			'Retencion' => 
				array(
				'text' => 'Retención',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'RegistroRetencion'=> 
							array(
								'text' => 'Registro Retención', 
								'type' => 'item',
								'id' => 'retencion',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'retencion')
								)
							),
							'ValidarRetenciones'=> 
							array(
								'text' => 'Validar Retenciones', 
								'type' => 'item',
								'id' => 'validar_retencion',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'validar_retencion')
								)
							)
						)
					)
				),
			'FacturaVenta' => 
				array(
				'text' => 'Factura Venta',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'RegistroFactura'=> 
							array(
								'text' => 'Registro Factura', 
								'type' => 'item',
								'id' => 'factura_venta',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'factura_venta')
								)
							),
							'ValidarFacturasVenta'=> 
							array(
								'text' => 'Validar Facturas Venta', 
								'type' => 'item',
								'id' => 'validar_factura_venta',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'validar_factura_venta')
								)
							)
						)
					)
				),
			'NotaCredito' => 
				array(
				'text' => 'Nota Crédito',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'RegistroNotaCredito'=> 
							array(
								'text' => 'Registro Nota Crédito', 
								'type' => 'item',
								'id' => 'nota_credito',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'nota_credito')
								)
							),
							'ValidarFacturasVenta'=> 
							array(
								'text' => 'Validar Notas Crédito', 
								'type' => 'item',
								'id' => 'validar_nota_credito',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'validar_nota_credito')
								)
							)
						)
					)
				),
			'NotaDebito' => 
				array(
				'text' => 'Nota Débito',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'RegistroNotaDebito'=> 
							array(
								'text' => 'Registro Nota Débito', 
								'type' => 'item',
								'id' => 'nota_debito',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'nota_debito')
								)
							),
							'ValidarNotaDebito'=> 
							array(
								'text' => 'Validar Notas Débito', 
								'type' => 'item',
								'id' => 'validar_nota_debito',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'validar_nota_debito')
								)
							)
						)
					)
				),
			'Guia Remisión' => 
				array(
				'text' => 'Guia Remisión',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'RegistroGuiaRemision'=> 
							array(
								'text' => 'Registro Guia Remisión', 
								'type' => 'item',
								'id' => 'guia_remision',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'guia_remision')
								)
							),
							'ValidarGuiaRemision'=> 
							array(
								'text' => 'Validar Guias Remisión', 
								'type' => 'item',
								'id' => 'validar_guia_remision',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'validar_guia_remision')
								)
							)
						)
					)
				),
			'Transacciones' => 
				array(
				'text' => 'Transacciones',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'NuevoIngreso'=> 
							array(
								'text' => 'Registro Ingreso', 
								'type' => 'item',
								'id' => 'ingresos',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'ingresos')
								)
							),
							'NuevoEgreso'=> 
							array(
								'text' => 'Registro Egreso', 
								'type' => 'item',
								'id' => 'egresos',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'egresos')
								)
							)
						)
					)
				),
			'Cartera' => 
				array(
				'text' => 'Cartera',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'CuentasCobrar'=> 
							array(
								'text' => 'Cuentas Cobrar', 
								'type' => 'item',
								'id' => 'cuentas_cobrar',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'cuentas_cobrar')
								)
							),
							'CuentasPagar'=> 
							array(
								'text' => 'Cuentas Pagar', 
								'type' => 'item',
								'id' => 'cuentas_pagar',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'cuentas_pagar')
								)
							)
						)
					)
				),
			'Usuarios' => 
			array(
				'text' => 'Usuarios',
				'type' => 'folder',
				'additionalParameters' => 
					array(
						'id' => 1,
						'children' => 
						array(
							'Perfiles'=> 
							array(
								'text' => 'Perfiles', 
								'type' => 'item',
								'id' => 'cargos',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'cargos')
								)
							),
							'RegistroUsuario'=> 
							array(
								'text' => 'Registro Usuario', 
								'type' => 'item',
								'id' => 'usuarios',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'usuarios')
								)
							),
							'Privilegios'=> 
							array(
								'text' => 'Privilegios', 
								'type' => 'item',
								'id' => 'privilegios',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'privilegios')
								)
							)							
						)
					)
				),
			'Reportes' => 
				array(
				'text' => 'Reportes',
				'type' => 'folder',
				'additionalParameters' => 
				array(
					'id' => 1,
					'children' => 
						array(
							'ReporteProductos'=> 
							array(
								'text' => 'Reportes Productos', 
								'type' => 'item',
								'id' => 'reporte_productos',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'reporte_productos')
								)
							),
							'ReporteCompras'=> 
							array(
								'text' => 'Reportes Estadisticos', 
								'type' => 'item',
								'id' => 'reporte_compras',
								'additionalParameters' => 
								array(
									'item-selected' => buscarstatus($sum,'reporte_compras')
								)
							)
						)
					)
				),
			
			);
		$resultado = $class->consulta("SELECT * FROM usuarios WHERE ESTADO = '1' order by id asc");
		while ($row=$class->fetch_array($resultado)) {
		}
		$acu2;
		for ($i = 0; $i < count($acu); $i++) { 
			$acu2[$i] = array(
							'text' => $acu[$i], 
							'type' => 'folder',
							'additionalParameters' => 
												array(
													'id' => '1',
													'children'=> 
													array('opcion2' => 
														array(
															'text' => 'opcion2', 
															'type' => 'item',
															'id'=>'moji',
															'additionalParameters' => 
															array(
																'item-selected' => true
															)
														)
													)
												)
											);
		}

		print(json_encode($acumulador));
	}
	// fin
?>

