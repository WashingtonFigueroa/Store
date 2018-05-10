<?php
    include_once('../../admin/class.php');		 
    include_once('../../admin/correolocal.php');
    //include_once('../../admin/correoweb.php');		    
	if(!isset($_SESSION)) {
        session_start();                
    }
   	error_reporting(0);
    $class = new constante();	
	$fecha = $class->fecha();	
	$defaulMail = mailDefecto;

	$data = array();
	if (isset($_POST['reenviarCorreo']) == "reenviarCorreo") {
		$resultado = $class->consulta("SELECT C.correo, C.nombre_comercial, F.total_venta FROM factura_venta F, clientes C WHERE F.id_cliente = C.id AND F.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {						
			$email = $row[0];
			$nombre = $row[1];
			$total = $row[2];
		} 
		
		if(trim($email) == '') {
			$resultado = $class->consulta("UPDATE factura_venta SET estado = '1' WHERE id = '".$_POST['id']."'");

			if($resultado) {
				$data = 1; // datos actualizados
			} else {
				$data = 4; // error al momento de guadar
			}
		} else {
			include 'generarPDF.php';			        				      
			$data = correo($fecha,$total,$_POST['aut'].'.xml',$_POST['aut'].'.pdf', $nombre, $email,'../factura_venta/comprobantes/'.$_POST['aut'].'.xml',generarPDF($_POST['id']),1);

			if($data == 1) {
				$resultado = $class->consulta("UPDATE factura_venta set estado = '1' where id = '".$_POST['id']."'");

				if($resultado) {
					$data = 1; // datos actualizados
				} else {
					$data = 4; // error al momento de guadar
				}
			}	
		}			
		
		echo $data;
	}

	if (isset($_POST['generarArchivos']) == "generarArchivos") {
		include '../factura_venta/generarXML.php';
		include '../factura_venta/firma/firma.php';					

		$codDoc = '01'; // tipo documento
		$resultado = $class->consulta("SELECT F.emision, E.token, E.clave, F.clave_acceso, C.correo, C.nombre_comercial, F.total_venta FROM factura_venta F, empresa E, clientes C WHERE F.id_empresa = E.id AND F.id_cliente = C.id AND F.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$emision = $row[0];
			$token = $row[1];
			$pass = $row[2];
			$clave = $row[3];
			$email = $row[4];
			$nombre = $row[5];
			$total = $row[6];
		}

		// parametro ambiente
		$resultado = $class->consulta("SELECT codigo FROM tipo_ambiente WHERE principal = 'Si' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$ambiente = $row[0];
		}
		// fin

		$respuesta = consultarComprobante($ambiente, $clave);									
		if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado) == 'AUTORIZADO') {
			if($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado == 'AUTORIZADO') {		
	    	    $numeroAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
		        $fechaAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
	            $ambienteAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente;
	            $class->consulta("UPDATE factura_venta SET fecha_autorizacion = '".$fechaAutorizacion."', estado = '2', numero_autorizacion = '".$numeroAutorizacion."', ambiente = '".$ambienteAutorizacion."' WHERE id = '".$_POST['id']."'");

	            $dataFile = generarXMLCDATA($respuesta);		                
	            $doc = new DOMDocument('1.0', 'UTF-8');
				$doc->loadXML($dataFile);//xml	 
				if($doc->save('../factura_venta/comprobantes/'.$numeroAutorizacion.'.xml')) {
					/*include '../generarPDF.php';						
	    			$data = correo($fecha,$totalComprobante,'./comprobantes/'.$numeroAutorizacion.'.xml','../comprobantes/'.$numeroAutorizacion.'.pdf',$_POST['nombreComercial'],$mail,$doc->saveXML(),generarPDF($id),0);*/
	    			if(trim($email) == '') {		
						$resultado = $class->consulta("UPDATE factura_venta SET estado = '1' WHERE id = '".$_POST['id']."'");

						if($resultado) {
							//datos actualizados
							$data = 1; 
						} else {
							//error al momento de guadar
							$data = 4;
						}
					} else {
	    				$data = 3; // error al momento de enviar el correo
					    $class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");	
	    			}	    			
				} else {
					$data = 2; // error al generar los documentos
			        $class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");			                	
				} 
			} else {
				$data = 7; // Error en el service web rechazado
				$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");		
			}     
		} else {
			$data = 7; // Error en el service web rechazado
			$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");	
		}

		echo $data;
	}

	if (isset($_POST['errorWebService']) == "errorWebService") {		
		include '../factura_venta/generarXML.php';		
		include '../factura_venta/firma/firma.php';	
		include '../factura_venta/firma/xades.php';

		$codDoc = '01'; // tipo documento
		$resultado = $class->consulta("SELECT F.emision, E.token, E.clave, F.clave_acceso, C.correo, C.nombre_comercial, F.total_venta FROM factura_venta F, empresa E, clientes C WHERE F.id_empresa = E.id AND F.id_cliente = C.id AND F.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$emision = $row[0];
			$token = $row[1];
			$pass = $row[2];
			$clave = $row[3];
			$email = $row[4];
			$nombre = $row[5];
			$total = $row[6];
		}

		// parametro ambiente
		$resultado = $class->consulta("SELECT codigo FROM tipo_ambiente WHERE principal = 'Si' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$ambiente = $row[0];
		}
		// fin

		$xml = generarXML($_POST['id'], $codDoc, $ambiente, $emision); // generar xml
			
		$firmado = generarFirma($xml, $clave, 'factura', $pass, $token, $ambiente,'1'); // firmar xml

		if($firmado == 5) {
			$data = 5;//ARCHIVO NO EXISTE
		}else{
			if($firmado == 6) {
				$data = 6;////CONTRASEÑA DE TOKEN INCORRECTA
			} else {												
				$respuesta = consultarComprobante($ambiente, $clave);
				if($respuesta->RespuestaAutorizacionComprobante->numeroComprobantes == 0) {	
					if(isset($respWeb['RespuestaRecepcionComprobante']['estado']) == 'RECIBIDA') {
						$respuesta = consultarComprobante($ambiente, $clave);									
						if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado)) {
							if($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado == 'AUTORIZADO') {
			            	    $numeroAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
			        	        $fechaAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
			    	            $ambienteAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente;
				                $class->consulta("UPDATE factura_venta SET fecha_autorizacion = '".$fechaAutorizacion."', estado = '2', numero_autorizacion = '".$numeroAutorizacion."', ambiente = '".$ambienteAutorizacion."' WHERE id = '".$_POST['id']."'");

				                $dataFile = generarXMLCDATA($respuesta);		                
				                $doc = new DOMDocument('1.0', 'UTF-8');
			        			$doc->loadXML($dataFile);//xml	 
			        			if($doc->save('../factura_venta/comprobantes/'.$numeroAutorizacion.'.xml')) {
			        				/*include '../generarPDF.php';				        				
				        			$data = correo($fecha,$totalComprobante,'./comprobantes/'.$numeroAutorizacion.'.xml','../comprobantes/'.$numeroAutorizacion.'.pdf',$_POST['nombreComercial'],$mail,$doc->saveXML(),generarPDF($id),0);*/
				        			if(trim($email) == '') {
				        				$resultado = $class->consulta("UPDATE factura_venta SET estado = '1' WHERE id = '".$_POST['id']."'");

										if($resultado) {
											//datos actualizados
											$data = 1; 
										} else {
											//error al momento de guadar
											$data = 4;
										}
									} else {
										$data = 3; // error al momento de enviar el correo
					    				$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");
					    			}	
			        			} else {
			        				$data = 2; // error al generar los documentos
			        				$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");                	
			        			}
		        			} else {
		        				$data = 7; // Error en el service web rechazado
								$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");
		        			}      
						} else {
							$data = 7; // Error en el service web rechazado
							$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");
						}
					} else {
						$data = 8; // Error en el service web
						$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");
					}
				} else {
					if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado) == 'AUTORIZADO') {
						//$estado = 3;//autorizado actuzalizar los campos faltantes en el comprobante
	            	    $numeroAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
	        	        $fechaAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
	    	            $ambienteAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente;
		                $class->consulta("UPDATE factura_venta SET fecha_autorizacion = '".$fechaAutorizacion."', estado = '2', numero_autorizacion = '".$numeroAutorizacion."', ambiente = '".$ambienteAutorizacion."' WHERE id = '".$_POST['id']."'");

		                $dataFile = generarXMLCDATA($respuesta);		                
		                $doc = new DOMDocument('1.0', 'UTF-8');
	        			$doc->loadXML($dataFile);//xml	 
	        			if($doc->save('../factura_venta/comprobantes/'.$numeroAutorizacion.'.xml')) {
	        				/*include '../generarPDF.php';		        				
		        			$data = correo($fecha,$totalComprobante,'./comprobantes/'.$numeroAutorizacion.'.xml','../comprobantes/'.$numeroAutorizacion.'.pdf',$_POST['nombreComercial'],$mail,$doc->saveXML(),generarPDF($id),0);*/
		        			if(trim($email) == '') {
		        				$resultado = $class->consulta("UPDATE factura_venta SET estado = '1' WHERE id = '".$_POST['id']."'");

								if($resultado) {
									//datos actualizados
									$data = 1; 
								} else {
									//error al momento de guadar
									$data = 4;
								}
							} else {
			    				$data = 3; // error al momento de enviar el correo
					    		$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");	
			    			}
	        			} else {
	        				$data = 2; // error al generar los documentos
			        		$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");	
	        			}      
					} else {
						$data = 7; // Error en el service web rechazado
						$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");
					}
				}				
			}
		}

		echo $data;
	}

	if (isset($_POST['generarFirma']) == "generarFirma") {		
		include '../factura_venta/generarXML.php';		
		include '../factura_venta/firma/firma.php';	
		include '../factura_venta/firma/xades.php';

		$codDoc = '01'; // tipo documento
		$resultado = $class->consulta("SELECT F.emision, E.token, E.clave, F.clave_acceso, C.correo, C.nombre_comercial, F.total_venta FROM factura_venta F, empresa E, clientes C WHERE F.id_empresa = E.id AND F.id_cliente = C.id AND F.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$emision = $row[0];
			$token = $row[1];
			$pass = $row[2];
			$clave = $row[3];
			$email = $row[4];
			$nombre = $row[5];
			$total = $row[6];
		}

		// parametro ambiente
		$resultado = $class->consulta("SELECT codigo FROM tipo_ambiente WHERE principal = 'Si' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$ambiente = $row[0];
		}
		// fin

		$xml = generarXML($_POST['id'], $codDoc, $ambiente, $emision); // generar xml
			
		$firmado = generarFirma($xml, $clave, 'factura', $pass, $token, $ambiente,'1'); // firmar xml

		if($firmado == 5) {
			$data = 5; // ARCHIVO NO EXISTE
		} else {
			if($firmado == 6) {
				$data = 6; // CONTRASEÑA DE TOKEN INCORRECTA
			} else {
				$respWeb = webService($firmado, $ambiente, $clave,'','factura',$pass,$token,'0'); // Envio Archivo XML Validar 
				
				if($respWeb) {
					$estado = $respWeb['RespuestaRecepcionComprobante']['estado']; 
					if($estado == 'RECIBIDA') {
						$respuesta = consultarComprobante($ambiente, $clave);														
						if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado) == 'AUTORIZADO') {

		            	    $numeroAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
		        	        $fechaAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
		    	            $ambienteAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente;

			                $class->consulta("UPDATE factura_venta SET fecha_autorizacion = '".$fechaAutorizacion."', estado = '2', numero_autorizacion = '".$numeroAutorizacion."', ambiente = '".$ambienteAutorizacion."' WHERE id = '".$_POST['id']."'");

			                $dataFile = generarXMLCDATA($respuesta);		                
			                $doc = new DOMDocument('1.0', 'UTF-8');
		        			$doc->loadXML($dataFile); // xml
		        			if($doc->save('../factura_venta/comprobantes/'.$numeroAutorizacion.'.xml')) {
		        				include 'generarPDF.php';
			        			$data = correo($fecha,$total,$numeroAutorizacion.'.xml',$numeroAutorizacion.'.pdf',$nombre,$email,'../factura_venta/comprobantes/'.$numeroAutorizacion.'.xml',generarPDF($_POST['id']),1);

			        			if(trim($email) == '') {
			        				$resultado = $class->consulta("UPDATE factura_venta SET estado = '1' WHERE id = '".$_POST['id']."'");			
									if($resultado) {
										//datos actualizados
										$data = 1; 
									} else {
										//error al momento de guadar
										$data = 4;
									}
								} else {
									// error al momento de enviar el correo
									$data = 3; 
					    			$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'"); 
				    			}	
		        			} else {
		        				// ERROR AL GENERAR LOS DOCUMENTOS
		        				$data = 2;
			        			$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");               	
		        			}      
						} else {
							if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado) == 'NO AUTORIZADO') {
								$data = 7; // Error en el service web
								$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");
							}
						}
					} else {
						if($estado == 'DEVUELTA') {
							$data = 8; // Error en el service web
							$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");	
						}
					}
				}
			}
		}

		echo $data;
	}

	if (isset($_POST['volverValidar']) == "volverValidar") {
		include '../factura_venta/generarXML.php';		
		include '../factura_venta/firma/firma.php';	
		include '../factura_venta/firma/xades.php';

		$codDoc = '01'; // tipo documento
		$resultado = $class->consulta("SELECT F.emision, E.token, E.clave, F.clave_acceso, C.correo, C.nombre_comercial, F.total_venta FROM factura_venta F, empresa E, clientes C WHERE F.id_empresa = E.id AND F.id_cliente = C.id AND F.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$emision = $row[0];
			$token = $row[1];
			$pass = $row[2];
			$clave = $row[3];
			$email = $row[4];
			$nombre = $row[5];
			$total = $row[6];
		}

		// parametro ambiente
		$resultado = $class->consulta("SELECT codigo FROM tipo_ambiente WHERE principal = 'Si' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$ambiente = $row[0];
		}
		// fin

		$xml = generarXML($_POST['id'], $codDoc, $ambiente, $emision); // generar xml
			
		$firmado = generarFirma($xml, $clave, 'factura', $pass, $token, $ambiente,'1'); // firmar xml

		if($firmado == 5) {
			$data = 5; // ARCHIVO NO EXISTE
		} else {
			if($firmado == 6) {
				$data = 6; // CONTRASEÑA DE TOKEN INCORRECTA
			} else {
				$respWeb = webService($firmado,$ambiente,$clave,'','factura',$pass,$token,'0'); // Envio Archivo XML Validar 

				if($respWeb) {
					$estado = $respWeb['RespuestaRecepcionComprobante']['estado']; 
					if($estado == 'RECIBIDA') {
						$respuesta = consultarComprobante($ambiente, $clave);														
						if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado) == 'AUTORIZADO') {

		            	    $numeroAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
		        	        $fechaAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
		    	            $ambienteAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente;

			                $class->consulta("UPDATE factura_venta SET fecha_autorizacion = '".$fechaAutorizacion."', estado = '2', numero_autorizacion = '".$numeroAutorizacion."', ambiente = '".$ambienteAutorizacion."' WHERE id = '".$_POST['id']."'");

			                $dataFile = generarXMLCDATA($respuesta);		                
			                $doc = new DOMDocument('1.0', 'UTF-8');
		        			$doc->loadXML($dataFile); // xml
		        			if($doc->save('../factura_venta/comprobantes/'.$numeroAutorizacion.'.xml')) {
		        				include 'generarPDF.php';
			        			$data = correo($fecha,$total,$numeroAutorizacion.'.xml',$numeroAutorizacion.'.pdf',$nombre,$email,'../factura_venta/comprobantes/'.$numeroAutorizacion.'.xml',generarPDF($_POST['id']),1);

			        			if(trim($email) == '') {
			        				$resultado = $class->consulta("UPDATE factura_venta SET estado = '1' WHERE id = '".$_POST['id']."'");			
									if($resultado) {
										//datos actualizados
										$data = 1; 
									} else {
										//error al momento de guadar
										$data = 4;
									}
								} else {
									// error al momento de enviar el correo
									$data = 3; 
					    			$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'"); 
				    			}	
		        			} else {
		        				// ERROR AL GENERAR LOS DOCUMENTOS
		        				$data = 2;
			        			$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");               	
		        			}      
						} else {
							if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado) == 'NO AUTORIZADO') {
								$data = 7; // Error en el service web
								$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");
							}
						}
					} else {
						if($estado == 'DEVUELTA') {
							$data = 8; // Error en el service web
							$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$_POST['id']."'");	
						}
					}
				}
			}
		}

		echo $data;
	}	
?>	