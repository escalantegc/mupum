<?php
require_once('dao.php');
class ci_login extends toba_ci
{
	protected $s__datos;
	protected $s__datos_openid;
	protected $en_popup = false;
	protected $s__item_inicio;
	private $es_cambio_contrasenia = false;
	protected $s__persona;
	/**
	 * Guarda el id de la operación original así se hace una redirección una vez logueado
	 */
	function ini__operacion()
	{
		//--- Si el usuario pidio originalmente algún item distinto al de login, se fuerza como item de inicio de sesión
		$item_original = toba::memoria()->get_item_solicitado_original();
		$item_actual = toba::memoria()->get_item_solicitado();
		if (isset($item_original) && isset($item_actual) &&
				$item_actual[1] != $item_original[1]) {
			toba::proyecto()->set_parametro('item_inicio_sesion', $item_original[1]);
		}
		$this->s__item_inicio = null;
		if (isset($this->s__datos_openid)) {
			unset($this->s__datos_openid);
		}
	}

	function ini()
	{
		toba_ci::set_navegacion_ajax(false);
		$this->en_popup = toba::proyecto()->get_parametro('item_pre_sesion_popup');
		if (toba::instalacion()->get_tipo_autenticacion() == 'openid') {
			try {
				toba::manejador_sesiones()->get_autenticacion()->verificar_acceso();
			} catch (toba_error_autenticacion $e) {
				//-- Caso error de validación
				toba::notificacion()->agregar($e->getMessage());
			}
		}
		$tipo_auth = toba::instalacion()->get_tipo_autenticacion();
		if (toba_autenticacion::es_autenticacion_centralizada($tipo_auth)) {
			if (! toba::manejador_sesiones()->get_autenticacion()->permite_login_toba()) {
				$this->evt__cas__ingresar();
			}
		}		
	}
	
	function conf__login()
	{
		if ( ! toba::proyecto()->get_parametro('validacion_debug') ) {
			$this->pantalla()->eliminar_dep('seleccion_usuario');
		}		
		$this->eliminar_dependencias_no_usadas();										//Quito los forms que no uso dependiendo del tipo de autenticacion
		if ($this->en_popup && toba::manejador_sesiones()->existe_usuario_activo()) {
			//Si ya esta logueado y se abre el sistema en popup, ocultar componentes visuales
			$this->pantalla()->set_titulo('');			
			if ($this->pantalla()->existe_dependencia('seleccion_usuario')) {
				$this->pantalla()->eliminar_dep('seleccion_usuario');
			}
			if ($this->pantalla()->existe_dependencia('datos')) {
				$this->pantalla()->eliminar_dep('datos');
			}			
			if ($this->pantalla()->existe_evento('Ingresar')) {
				$this->pantalla()->eliminar_evento('Ingresar');
			}
		}		
	}	
	
	/**
	 * Elimina los formularios que no se usan segun el tipo de autenticacion indicado en instalacion.ini
	 */
	function eliminar_dependencias_no_usadas()
	{
		$tipo_auth = toba::instalacion()->get_tipo_autenticacion();	
		switch($tipo_auth) {
		case 'openid':
			if (! toba::manejador_sesiones()->get_autenticacion()->permite_login_toba() && $this->pantalla()->existe_dependencia('datos')) {
				$this->pantalla()->eliminar_dep('datos');
			}
			if ($this->pantalla()->existe_dependencia('cas')) {
				$this	->pantalla()->eliminar_dep('cas');
			}
			break;
		case 'cas':
		case 'saml':
		case 'saml_onelogin':
			if (! toba::manejador_sesiones()->get_autenticacion()->permite_login_toba() && $this->pantalla()->existe_dependencia('datos')) {
				$this->pantalla()->eliminar_dep('datos');
			}
			if ($this->pantalla()->existe_dependencia('openid')) {
				$this->pantalla()->eliminar_dep('openid');
			}
			break;				
		default:
			if ($this->pantalla()->existe_dependencia('openid')) {
				$this->pantalla()->eliminar_dep('openid');
			}
			if ($this->pantalla()->existe_dependencia('cas')) {
				$this->pantalla()->eliminar_dep('cas');
			}
		}	
	}
	
	/**
	 * 
	 * @throws toba_reset_nucleo
	 * @ignore
	 */
	function post_eventos()
	{
		if ($this->es_cambio_contrasenia) {
			return;						//Fuerza a que no intente loguear, sino que redirija a la pantalla de login
		}
		try {		
			$this->invocar_autenticacion_por_tipo();
		} catch (toba_error_autenticacion $e) {
			//-- Caso error de validación
			$this->resetear_marca_login();
			toba::notificacion()->agregar($e->getMessage());
		} catch (toba_error_autenticacion_intentos $e) {
			//-- Caso varios intentos fallidos con captcha
			$this->resetear_marca_login();
			list($msg, $intentos) = explode('|', $e->getMessage());
			toba::notificacion()->agregar($msg);
			toba::memoria()->set_dato_instancia('toba_intentos_fallidos_login', $intentos);
		} catch (toba_error_login_contrasenia_vencida $e) {
			$this->resetear_marca_login();
			$this->set_pantalla('cambiar_contrasenia');
		} catch (toba_reset_nucleo $reset) {
			//-- Caso validacion exitosa, elimino la marca de intentos fallidos
			if (toba::memoria()->get_dato_instancia('toba_intentos_fallidos_login') !== null) {
				toba::memoria()->eliminar_dato_instancia('toba_intentos_fallidos_login');
			}
			//-- Se redirige solo si no es popup
			/*if (! $this->en_popup) {
				throw $reset;
			}*/
			$this->s__item_inicio = $reset->get_item();	//Se guarda el item de inicio al que queria derivar el nucleo
		}
		return;
	}

	/**
	 * Hace el llamado a toba_manejador_sesiones segun el metodo indicado en instalacion.ini 
	 * y que ingreso el usuario.
	 */
	function invocar_autenticacion_por_tipo()
	{
		$tipo_auth = toba::instalacion()->get_tipo_autenticacion();
		if (isset($this->s__datos['usuario']) || isset($this->s__datos_openid['provider'])) {			//Para el caso de autenticacion basica y OpenId
			if ($tipo_auth == 'openid' && isset($this->s__datos_openid)) {
				toba::manejador_sesiones()->get_autenticacion()->set_provider($this->s__datos_openid);
			}
			$usuario = (isset($this->s__datos['usuario'])) ? $this->s__datos['usuario'] : '';
			$clave = (isset($this->s__datos['clave'])) ? $this->s__datos['clave'] : '';

			if (toba_autenticacion::es_autenticacion_centralizada($tipo_auth)) {
				toba::manejador_sesiones()->get_autenticacion()->usar_login_basico();
			}			
			toba::manejador_sesiones()->login($usuario, $clave);

		} elseif (toba_autenticacion::es_autenticacion_centralizada($tipo_auth) && toba::manejador_sesiones()->get_autenticacion()->uso_login_centralizado()) {	//El control por session es para que no redireccione automaticamente
			toba::manejador_sesiones()->get_autenticacion()->verificar_acceso();
		}	
	}	
	
	/**
	 * Elimina  la marca del login basico ante un fallido, de manera que si luego loguea centralizado desloguee correctamente
	 * @ignore
	 */
	protected function resetear_marca_login()
	{
		if (toba::manejador_sesiones()->get_autenticacion()->uso_login_basico()) {
			toba::manejador_sesiones()->get_autenticacion()->eliminar_login_basico();
		}
	}
	
	//-------------------------------------------------------------------
	//--- DEPENDENCIAS
	//-------------------------------------------------------------------

	//---- datos -------------------------------------------------------

	function evt__datos__ingresar($datos)
	{
		if (isset($this->s__datos_openid)) {
			unset($this->s__datos_openid);
		}		
		toba::logger()->desactivar();
		if (isset($datos['test_error_repetido']) && !$datos['test_error_repetido']) {
			throw new toba_error_autenticacion('El valor ingresado de confirmación no es correcto');
		} else {
			$this->s__datos = $datos;
		}
	}
	
	function conf__datos(toba_ei_formulario $form)
	{
		if (toba::memoria()->get_dato_instancia('toba_intentos_fallidos_login') === null) {
			$form->desactivar_efs(array('test_error_repetido'));
		}
		if (toba::instalacion()->get_tipo_autenticacion() != 'openid') {
			$form->set_titulo('');
		}
		if (isset($this->s__datos)) {
			if (isset($this->s__datos['clave'])) {
				unset($this->s__datos['clave']);
			}
			$form->set_datos($this->s__datos);
		}
	}	
	
	
	//---- open_id -------------------------------------------------------
	
	function evt__openid__ingresar($datos)
	{
		if (isset($this->s__datos)) {
			unset($this->s__datos);
		} 
		$this->s__datos_openid = $datos;
	}	

	function conf__openid(toba_ei_formulario $form)
	{
		$providers = $this->get_openid_providers();
		if (! empty($providers)) {
			$provider = current($providers);
			$form->set_datos_defecto(array('provider' => $provider['id']));
		}
		if (isset($this->s__datos_openid)) {
			$form->set_datos($this->s__datos_openid);
		}
	}	
	
	
	function get_openid_providers() 
	{
		return toba::manejador_sesiones()->get_autenticacion()->get_providers();
	}

	//---- cas -----------------------------------------------------------------------
	function evt__cas__ingresar()
	{
		toba::manejador_sesiones()->get_autenticacion()->usar_login_centralizado();
		try {
			toba::manejador_sesiones()->get_autenticacion()->verificar_acceso();
		} catch (toba_error_autenticacion $e) {
			//-- Caso error de validación				
			toba::notificacion()->agregar($e->getMessage());	
		}
	}

	//---- seleccion_usuario -------------------------------------------------------

	function evt__seleccion_usuario__seleccion($seleccion)
	{
		$this->s__datos['usuario'] = $seleccion['usuario'];
		$this->s__datos['clave'] = null;
	}

	function conf__seleccion_usuario()
	{
		return toba::instancia()->get_lista_usuarios();
	}
	
	//-----------------------------------------------------------------------------------
	//---- form_passwd_vencido ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_passwd_vencido($form)
	{
		$largo_clave =  toba_parametros::get_largo_pwd(toba::proyecto()->get_id());
		$form->ef('clave_nueva')->set_expreg(toba_usuario::get_exp_reg_pwd($largo_clave));
		$form->ef('clave_nueva')->set_descripcion("La clave debe tener al menos $largo_clave caracteres, entre letras mayúsculas, minúsculas, números y símbolos, no pudiendo repetir caracteres adyacentes");
		$form->set_datos(array());
	}
	
	function evt__form_passwd_vencido__modificacion($datos)
	{
		$usuario = $this->s__datos['usuario'];		
		if (toba::manejador_sesiones()->invocar_autenticar($usuario, $datos['clave_anterior'], null)) {		//Si la clave anterior coincide	
			 $proyecto = toba::proyecto()->get_id();
			//Verifico que no intenta volver a cambiarla antes del periodo permitido
			$dias_minimos = toba_parametros::get_clave_validez_minima($proyecto);
			if (! is_null($dias_minimos)) {
				if (! toba_usuario::verificar_periodo_minimo_cambio($usuario, $dias_minimos)) {
					toba::notificacion()->agregar('No transcurrio el período minimo para poder volver a cambiar su contraseña. Intentelo en otra ocasión');
					return;
				}
			}		
			//Obtengo el largo minimo de la clave			
			$largo_clave = toba_parametros::get_largo_pwd($proyecto);
			try {
				toba_usuario::verificar_composicion_clave($datos['clave_nueva'], $largo_clave);
			
				//Obtengo los dias de validez de la nueva clave
				$dias = toba_parametros::get_clave_validez_maxima($proyecto);
				$ultimas_claves = toba_parametros::get_nro_claves_no_repetidas($proyecto);
				toba_usuario::verificar_clave_no_utilizada($datos['clave_nueva'], $usuario, $ultimas_claves);
				toba_usuario::reemplazar_clave_vencida($datos['clave_nueva'], $usuario, $dias);
				$this->es_cambio_contrasenia = true;				//Bandera para el post_eventos
			} catch(toba_error_pwd_conformacion_invalida $e) {
				toba::logger()->info($e->getMessage());
				toba::notificacion()->agregar($e->getMessage(), 'error');
				return;
			}
		} else {
			throw new toba_error_usuario('La clave ingresada no es correcta');
		}
		$this->set_pantalla('login');
	}

	function evt__form_passwd_vencido__cancelar()
	{
		$this->set_pantalla('login');
	}
	
	//-------------------------------------------------------------------
	
	function extender_objeto_js()
	{
		$escapador = toba::escaper();
		if (toba::instalacion()->get_tipo_autenticacion() == 'openid') {
			$personalizable = '';
			foreach ($this->get_openid_providers() as $id => $provider) {
				if (isset($provider['personalizable']) && $provider['personalizable']) {
					$personalizable = $escapador->escapeJs($id);
				}
			}
			echo $escapador->escapeJs($this->dep('openid')->objeto_js)
				.".evt__provider__procesar = function(inicial) {
					if (this.ef('provider').get_estado() == '$personalizable') {
						this.ef('provider_url').mostrar();
					} else {
						this.ef('provider_url').ocultar();
					}
				}
			";
		}
				
		$finalizar = toba::memoria()->get_parametro(apex_sesion_qs_finalizar);
		if (is_null($finalizar)) {											//Sesion activa
			if (toba::manejador_sesiones()->existe_usuario_activo()) {
				//Si ya esta logueado y se abre el sistema en popup, abrirlo
				if (isset($this->s__item_inicio)) {
					list($proyecto, $item) = explode($this->s__item_inicio);
				} else {
					$proyecto = toba::proyecto()->get_id();
					$item = toba::proyecto()->get_parametro('item_inicio_sesion');
				}
				$url = $escapador->escapeJs(toba::vinculador()->get_url($proyecto, $item));
				
				if ($this->en_popup) {
					echo " abrir_popup('sistema', '$url', {resizable: 1});	";
				} else {
					echo " window.location.href = '$url';";
				}
			}
		} elseif ($this->en_popup) {									//Se finaliza la sesion
				echo '
					if (window.opener &&  window.opener.location) {
						window.opener.location.href = window.opener.location.href; 
					}
					window.close();
				';
		}		
	}
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		
		try{
			$this->cn()->guardar_dr_registro();
			$this->enviar_correo($this->s__persona);
			$parametros = array('ts' => 'vista_jasperreports');
			toba::vinculador()->navegar_a('mupum', '3945', $parametros);
			
			toba::notificacion()->agregar("La solicitud de afiliacion ha sido enviada correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La persona esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_documento'))
			{
				toba::notificacion()->agregar("La persona ya esta registrada.",'info');
				
			} 		

			if(strstr($mensaje_log,'idx_legajo'))
			{
				toba::notificacion()->agregar("El socio ya esta registrado.",'info');
				
			} 	
			if(strstr($mensaje_log,'telefono_por_persona_pkey'))
			{
				toba::notificacion()->agregar("Ya registro ese numero de telefono",'info');
				
			} 	

			if(strstr($mensaje_log,'idx_afiliado'))
			{
				toba::notificacion()->agregar("Usted ya se encuentra afiliado.",'info');
				
			} 
			if(strstr($mensaje_log,'idx_afiliacion_solicitada'))
			{
				toba::notificacion()->agregar("Usted ya realizo la solicitud de afiliacion o tiene una afiliacion activa.",'info');
				
			} 
					

			
		
			
		}
			$this->cn()->resetear_dr_registro();
			$this->set_pantalla('login');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_registro();
		$this->set_pantalla('login');
	}

	function evt__datos__afiliacion()
	{
		$this->set_pantalla('pant_registro');
	}
	

	
	//-----------------------------------------------------------------------------------
	//---- frm_persona ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_persona(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_persona())
		{
			$datos = $this->cn()->get_dt_persona();
			$form->set_datos($datos);
		}
	}

	function evt__frm_persona__modificacion($datos)
	{
		$persona['idtipo_documento'] = $datos['idtipo_documento']; 
		$persona['nro_documento'] = $datos['nro_documento']; 
		$this->cn()->cargar_dr_registro($persona);
		$resultado = $this->cn()->existe_dt_persona($persona);
		if ($resultado == 'existe')
		{
			$this->cn()->set_cursor_dt_persona($persona);	
		}
		$datos['tipo_documento'] = dao::get_descripcion_tipo_documento($datos['idtipo_documento']);
		
		$this->s__persona = $datos;
		if ($this->cn()->hay_cursor_dt_persona())
		{
			$this->cn()->set_dt_persona($datos);
		} else {
			$this->cn()->agregar_dt_persona($datos);
		}

		$afiliacion['idtipo_socio'] = $datos['idtipo_socio'];
		$afiliacion['solicitada'] = 't';
		$afiliacion['fecha_solicitud'] =  date("d-m-Y");    
		$this->s__persona['fecha_solicitud'] = $afiliacion['fecha_solicitud'];
		$this->cn()->agregar_dt_afiliacion($afiliacion);	
				
	}


	function enviar_correo($persona)
	{
        //Armo el mail nuevo &oacute;
        $asunto = "Constancia de Solicitud de afiliacion";
        $cuerpo_mail = "<p>Estimado/a: </p>".trim($persona['apellido']) .", " .trim($persona['nombres'])."<br />
        				<p>Por medio del presente le informamos que la Solicitud de Afiliacion ha sido enviada correctamente con los siguentes datos: </p> 
        				<table>
						<tbody>
							<tr>
								<td>Documento: ".trim($persona['tipo_documento'])." - ".trim($persona['nro_documento'])."</td>
							</tr>
							<tr>
								<td>Legajo: ".trim($persona['legajo'])."</td>
							</tr>
							<tr>
								<td>Apellido y Nombres: ".trim($persona['apellido']).", ".trim($persona['nombres'])."</td>
							</tr>
							<tr>
								<td>Correo: ".trim($persona['correo'])."</td>
							</tr>
							<tr>
								<td>Telefono: ".trim($persona['tipo_telefono'])." - ".trim($persona['nro_telefono'])."</td>
							
							</tr>
							<tr>
								<td> Fecha Solicitud: ".trim($persona['fecha_solicitud'])."</td>
							</tr>
						</tbody>
					</table>
        				<br />
           				Saludos ATTE .- </br >  MUPUM</br>".
          				"<p>No responda este correo, fue generado por sistema. </p>";
        try 
        {
                $mail = new toba_mail(trim($persona['correo']), $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
                $mail->set_html(true);
                /*$direcciones[]= 'administracion@mupum.unam.edu.ar';
                $direcciones[]= 'comision@mupum.unam.edu.ar';
                $mail->set_cc($direcciones);*/
                $mail->enviar();
        } catch (toba_error $error) {
                $chupo = $error->get_mensaje_log();
                toba::notificacion()->agregar($chupo, 'info');
        }
	}



	//-----------------------------------------------------------------------------------
	//---- datos ------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__datos__soy_afiliado()
	{
		$this->set_pantalla('pant_usuario');
	}

	//-----------------------------------------------------------------------------------
	//---- frm_telefono -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__frm_telefono__modificacion($datos)
	{
		$this->s__persona['tipo_telefono'] = dao::get_descripcion_tipo_telefono($datos['idtipo_telefono']);
		$this->s__persona['nro_telefono'] = $datos['nro_telefono'];
		$telefonos = $this->cn()->get_dt_telefonos();
		$bandera = 'noexiste';
		foreach ($telefonos as $telefono) 
		{
			if (($telefono['idtipo_telefono'] == $datos['idtipo_telefono'] ) and (trim($telefono['nro_telefono']) == trim($datos['nro_telefono'] )))
			{
					$bandera = 'existe';
			}
		}

		if ($bandera == 'noexiste')
		{
			$this->cn()->agregar_dt_telefonos($datos);	
		}
			
	}
	//-----------------------------------------------------------------------------------
	//---- frm_afiliacion ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_afiliacion(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$form->set_datos($datos);
		}
			
	}
	
	function evt__frm_afiliacion__modificacion($datos)
	{
		
		
	}

	function vista_jasperreports(toba_vista_jasperreports $report)
	{
		$persona['idtipo_documento'] = $this->s__persona['idtipo_documento'];
		$persona['nro_documento'] = $this->s__persona['nro_documento'];
		$this->cn()->cargar_dr_registro($persona);
		$this->cn()->set_cursor_dt_persona($persona);
		if ($this->cn()->hay_cursor_dt_persona())
		{
			$persona = $this->cn()->get_dt_persona();
		}
		$idpersona = $persona['idpersona'];
		$reporte ='constancia_solicitud_afiliacion.jasper';
		$path = toba::proyecto()->get_path().'/exportaciones/'.$reporte;	

		$path_logo = toba::proyecto()->get_path().'/www/logo/logo.gif';	

		$report->set_path_reporte($path);
		//Parametro para el titulo
		$report->set_parametro('titulo','S','CONSTANCIA DE SOLICITUD DE AFILIACION ');
		//Parametros para el encabezado del titulo
		$report->set_parametro('logo','S',$path_logo);
		//Paramentro del filtro
	
		$report->set_parametro('idpersona', 'E', $idpersona);
		//Parametros para el usuario
		//$report->set_parametro('usuario','S',toba::usuario()->get_id());
		$report->set_nombre_archivo('constancia_solicitud_afiliacion'.$idpersona.'.pdf');   	
		$db = toba::fuente('mupum')->get_db();
		$report->set_conexion($db);	
	}

	/*function extender_objeto_js()
    {
  
    	echo "
        {$this->objeto_js}.evt__procesar = function(params) {
            location.href = vinculador.get_url(null, null, 'vista_jasperreports', {'idpersona': params});
   
            return false;
        }
		";
        
    }*/


	


	function enviar_correo_usuario($persona)
	{
		//try{
			$user = $persona['nro_documento']; 
	        $nombre = trim($persona['persona']);
	        $clave= toba_usuario::generar_clave_aleatoria(8);
	        $atributos['email'] = $persona['correo_correcto'];

	        $bloqueado = 'no';
	        if (toba::instancia()->es_usuario_bloqueado($user))
	        {
	        	$bloqueado = 'si';
	        } else {
	        	toba::instancia()->agregar_usuario($user,$nombre,$clave,$atributos);
		        $perfil = 'afiliado';
			    toba::instancia()->vincular_usuario('mupum',$user,$perfil);
	        }

	        //Armo el mail nuevo &oacute;
	        $asunto = "Datos de Acceso";
	        $cuerpo_mail='';
	        if ($bloqueado=='si')
	        {
	        	$cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br>".
	        				"<p>Por medio del presente le informamos que los datos para poder ingresar al sistema son:</p> ".
							"Usuario: ".$user. "<br>".
							"<p>Este usuario esta bloqueado, solicite al administrador del sistema que lo desbloquee. </p><br>".
	           				"<p>Saludos ATTE .- MUPUM</p>".
	          				"<p>No responda este correo, fue generado por sistema. </p>";
  			}else{
  				 $cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br>".
	        				"<p>Por medio del presente le informamos que los datos para poder ingresar al sistema son:</p> ".
							"Usuario: ".$user. "<br>".
							"Clave: ".$clave. "<br>".
							"<p>Debe respetar mayusculas y minisculas en la clave.</p>".
							"<p>Se solicita por favor complete los datos personales.</p>".
							"<p>Se recomienda que cambie la clave en cuanto pueda ingresar al sistema.</p>".
	           				"<p>Saludos ATTE .- MUPUM</p>".
	          				"<p>No responda este correo, fue generado por sistema. </p>";
  			}
	       

        try 
        {
                $mail = new toba_mail(trim($persona['correo']), $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
                $mail->set_html(true);
                //--$mail->set_cc();
                $mail->enviar();
        } catch (toba_error $error) {
                $chupo = $error->get_mensaje_log();
                toba::notificacion()->agregar($chupo, 'info');
        }
	}


//-----------------------------------------------------------------------------------
	//---- frm_usuario ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------


	function evt__frm_usuario__alta($datos)
	{
		$indice['idtipo_documento'] = $datos['idtipo_documento']; 
		$indice['nro_documento'] = $datos['nro_documento']; 
		$this->cn()->cargar_dr_registro($indice);
		$resultado = $this->cn()->existe_dt_persona($indice);
		if ($resultado == 'existe')
		{
			$this->cn()->set_cursor_dt_persona($indice);
			$persona = $this->cn()->get_dt_persona();	
			$this->s__persona = dao::get_listado_persona('persona.idpersona='.$persona['idpersona']);
			$this->s__persona[0]['correo_correcto'] = $datos['correo'] ;
			$this->enviar_correo_usuario($this->s__persona[0]);
			if ($this->cn()->hay_cursor_dt_persona())
			{
				$this->cn()->set_dt_persona($datos);
				toba::notificacion()->agregar("Los datos de acceso se guardaron correctamente.",'info');

			} else {
				$this->cn()->agregar_dt_persona($datos);
			}
		} else {
			 toba::notificacion()->agregar('Los datos ingresados no se corresponden con una persona afiliada', 'info');

		}
		
		try{
			$this->cn()->guardar_dr_registro();
		
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La persona esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_documento'))
			{
				toba::notificacion()->agregar("La persona ya esta registrada.",'info');
				
			} 		

			if(strstr($mensaje_log,'idx_legajo'))
			{
				toba::notificacion()->agregar("El socio ya esta registrado.",'info');
				
			} 	
			if(strstr($mensaje_log,'telefono_por_persona_pkey'))
			{
				toba::notificacion()->agregar("Ya registro ese numero de telefono",'info');
				
			} 	

			if(strstr($mensaje_log,'idx_afiliado'))
			{
				toba::notificacion()->agregar("Usted ya se encuentra afiliado.",'info');
				
			} 
			if(strstr($mensaje_log,'idx_afiliacion_solicitada'))
			{
				toba::notificacion()->agregar("Usted ya realizo la solicitud de afiliacion o tiene una afiliacion activa.",'info');
				
			} 
					
			
		}
			$this->cn()->resetear_dr_registro();
			$this->set_pantalla('login');
	}

	function evt__frm_usuario__cancelar()
	{
		$this->cn()->resetear_dr_registro();
		$this->set_pantalla('login');
	}

	function evt__datos__recuperar_clave()
	{
		$this->set_pantalla('pant_clave');
	}

	//-----------------------------------------------------------------------------------
	//---- frm_clave --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_clave(mupum_ei_formulario $form)
	{
	}

	function evt__frm_clave__alta($datos)
	{
		if ($datos['captcha'])
		{
			$indice['idtipo_documento'] = $datos['idtipo_documento']; 
			$indice['nro_documento'] = $datos['nro_documento']; 
			$this->cn()->cargar_dr_registro($indice);
			$resultado = $this->cn()->existe_dt_persona($indice);
			if ($resultado == 'existe')
			{
				$this->cn()->set_cursor_dt_persona($indice);
				$persona = $this->cn()->get_dt_persona();	
				$this->s__persona = dao::get_listado_persona('persona.idpersona='.$persona['idpersona']);
				$this->s__persona[0]['correo_correcto'] = $datos['correo'] ;
				$clave = toba_usuario::generar_clave_aleatoria(8);
				$this->s__persona[0]['clave'] = $clave;
				$this->enviar_correo_clave_usuario($this->s__persona[0]);
				

			} else {
				 toba::notificacion()->agregar('Los datos ingresados no se corresponden con una persona afiliada', 'info');

			}
			
			try{
				if(!toba::notificacion()->verificar_mensajes())
				{
					toba::notificacion()->agregar('La clave de acceso ha sido reseteada y enviada su correo correctamente.', 'info');	
				}

				$this->cn()->guardar_dr_registro();

				

				
			} catch( toba_error_db $error){
				$sql_state= $error->get_sqlstate();
				
				
						
				
			}
				$this->cn()->resetear_dr_registro();
				$this->set_pantalla('login');
		}else {
			toba::notificacion()->agregar('El codigo de seguridad es incorrecto', 'error');	
		}
	}

	function evt__frm_clave__cancelar()
	{
		$this->cn()->resetear_dr_registro();
		$this->set_pantalla('login');
	}


	function enviar_correo_clave_usuario($persona)
	{
		//try{
			$user = $persona['nro_documento']; 
	        $nombre = trim($persona['persona']);
	        $clave = $persona['clave'];
	        $atributos['email'] = $persona['correo_correcto'];

	        //Armo el mail nuevo &oacute;
	        $asunto = "Clave Recuperada";
	        
			 $cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br>".
	    				"<p>Por medio del presente le informamos que su clave ha sido reseteada, los nuevos datos de acceso son:</p> ".
						"Usuario: ".$user. "<br>".
						"Clave: ".$clave. "<br>".
						"<p>Debe respetar mayusculas y minisculas en la clave.</p>".
						"<p>Se recomienda que cambie la clave en cuanto pueda ingresar al sistema.</p>".
	       				"<p>Saludos ATTE .- MUPUM</p>".
	      				"<p>No responda este correo, fue generado por sistema. </p>";

        try 
        {
                $mail = new toba_mail(trim($persona['correo']), $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
                $mail->set_html(true);
                //--$mail->set_cc();
                $mail->enviar();
        } catch (toba_error $error) {
                $chupo = $error->get_mensaje_log();
                toba::notificacion()->agregar($chupo, 'info');
        }
	}

	function ajax__get_tipo_socio($idtipo_socio, toba_ajax_respuesta $respuesta)
	{
		$tipo = dao::get_tipo_socio($idtipo_socio);
		$respuesta->set($tipo);	
	}
}
?>