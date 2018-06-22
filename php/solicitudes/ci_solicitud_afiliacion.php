<?php
require_once('dao.php');
class ci_solicitud_afiliacion extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	protected $s__persona;


	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{	
			$datos = dao::get_listado_solicitud_afiliacion($this->s__where);
		}else{
			$datos = dao::get_listado_solicitud_afiliacion();
		}
		$cuadro->set_datos($datos);
		$servicio = toba::memoria()->get_servicio_solicitado();
		
		if(($servicio == 'vista_pdf') or ($servicio == 'vista_excel'))
		{
			$columnas[] = 'fecha_alta';
			$columnas[] = 'fecha_baja';
			$columnas[] = 'solicitada';
			$columnas[] = 'activa';

			$cuadro->eliminar_columnas($columnas);		
		}
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dt_afiliacion($seleccion);
		$this->cn()->set_cursor_dt_afiliacion($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__activar($seleccion)
	{
		$this->cn()->cargar_dt_afiliacion($seleccion);
		$this->cn()->set_cursor_dt_afiliacion($seleccion);
		$this->set_pantalla('pant_aceptar_afiliacion');
	}

	function evt__cuadro__baja($seleccion)
	{
		$this->cn()->cargar_dt_afiliacion($seleccion);
		$this->cn()->set_cursor_dt_afiliacion($seleccion);
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$this->s__persona = dao::get_listado_persona('persona.idpersona='.$datos['idpersona']);
			$this->enviar_correo_cancelacion($this->s__persona[0]);
			$datos['solicitada'] = 'f';
			$this->cn()->set_dt_afiliacion($datos);

		} else {
			$this->cn()->agregar_dt_afiliacion($datos);
		}
		
		try{
			$this->cn()->guardar_dt_afiliacion();
			
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La afiliacion esta siendo referenciado, no puede eliminarlo",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
				

			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');
			} 
			
		}
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
		
	}
	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(mupum_ei_filtro $filtro)
	{
		if(isset($this->s__datos_filtro))
		{
			$filtro->set_datos($this->s__datos_filtro);
			$this->s__where=$filtro->get_sql_where();
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- frm_edicion ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_edicion(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$form->set_datos($datos);
		}
	}

	
	function evt__frm_edicion__procesar($datos)
	{

		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$this->cn()->set_dt_afiliacion($datos);

		} else {
			$this->cn()->agregar_dt_afiliacion($datos);
		}

		try{

			$this->cn()->guardar_dt_afiliacion();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La afiliacion esta siendo referenciado, no puede eliminarlo",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_documento'))
			{
				toba::notificacion()->agregar("La afiliacion ya esta registrada.",'info');
			} 		

			if(strstr($mensaje_log,'idx_legajo'))
			{
				toba::notificacion()->agregar("El socio ya esta registrado.",'info');
			} 		

			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');

			} 
			if (strstr($mensaje_log,'apex_usuario_pk'))
			{
				toba::notificacion()->agregar('El usuario: '.$this->s__persona[0]['nro_documento'].' que quiere dar de alta ya existe', 'info');	
			}
			
		}
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}

	function evt__frm_edicion__cancelar()
	{
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}




	
	//-----------------------------------------------------------------------------------
	//---- frm_aceptar_afiliacion -------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_aceptar_afiliacion(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$form->set_datos($datos);
		}
	}

	function evt__frm_aceptar_afiliacion__procesar($datos)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion($datos))
		{
			$this->s__persona = dao::get_listado_persona('persona.idpersona='.$datos['idpersona']);
			$this->enviar_correo_aceptacion($this->s__persona[0]);
			$datos['activa'] = 't';
			$datos['solicitada'] = 'f';
			$this->cn()->set_dt_afiliacion($datos);

		} else {
			$this->cn()->agregar_dt_afiliacion($datos);
		}
		try{
			$this->cn()->guardar_dt_afiliacion();	
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La afiliacion esta siendo referenciado, no puede eliminarlo",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_documento'))
			{
				toba::notificacion()->agregar("La afiliacion ya esta registrada.",'info');
			} 		

			if(strstr($mensaje_log,'idx_legajo'))
			{
				toba::notificacion()->agregar("El socio ya esta registrado.",'info');
			} 		

			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');
			} 

			if (strstr($mensaje_log,'apex_usuario_pk'))
			{
				toba::notificacion()->agregar('El usuario: '.$this->s__persona[0]['nro_documento'].' que quiere dar de alta ya existe', 'info');	
			}
			
		}
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}

	function evt__frm_aceptar_afiliacion__cancelar()
	{
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}


	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	/**
	* Atrapa el evento seleccion del cuadro e invoca manualmente el serviccio vista_jasperreports pasandole el hash por parámetro
	*/
	/*function extender_objeto_js()
	{
		echo "
			{$this->dep('cuadro')->objeto_js}.evt__formulario = function(params) {
				location.href = vinculador.get_url(null, null, 'vista_jasperreports', {'id': params});
				return false;
			}
			{$this->dep('cuadro_cancelacion')->objeto_js}.evt__formulario = function(params) {
				location.href = vinculador.get_url(null, null, 'vista_jasperreports', {'idbaja': params});
				return false;
			}
		";
	}	*/

	

	function vista_jasperreports(toba_vista_jasperreports $report)
	{
		//toma como id el indice de la consulta, va de 0 a n
		$idafiliacion = toba::memoria()->get_parametro('id');
		$idbaja = toba::memoria()->get_parametro('idbaja');

		$datos = array();
		if (isset($idafiliacion))
		{
			//--leo los datos segun el filtro que tenga para que sepa los indice tal cuales esta en el cuadro
			if(isset($this->s__datos_filtro))
			{	
				$datos = dao::get_listado_solicitud_afiliacion($this->s__where);
			}else{
				$datos = dao::get_listado_solicitud_afiliacion();
			}
			$reporte ='formulario_afiliacion.jasper';
			$report->set_parametro('titulo','S','FORMULARIO DE ALTA DE AFILIACION ');
			$report->set_nombre_archivo('formulario_afiliacion'.$idafiliacion.'.pdf'); 
			$report->set_parametro('idafiliacion', 'E', $datos[$idafiliacion]['idafiliacion']);
		}
		if (isset($idbaja))
		{
			//--leo los datos segun el filtro que tenga para que sepa los indice tal cuales esta en el cuadro
			if(isset($this->s__datos_filtro))
			{	
				$datos = dao::get_listado_cancelacion_afiliacion ($this->s__where);
			}else{
				$datos = dao::get_listado_cancelacion_afiliacion();
			}
			$reporte ='formulario_baja_afiliacion.jasper';
			$report->set_parametro('titulo','S','FORMULARIO DE BAJA DE AFILIACION ');
			$report->set_nombre_archivo('formulario_afiliacion'.$idafiliacion.'.pdf'); 
			$report->set_parametro('idafiliacion', 'E', $datos[$idbaja]['idafiliacion']);

		}
		
		$path = toba::proyecto()->get_path().'/exportaciones/'.$reporte;	

		$path_logo = toba::proyecto()->get_path().'/www/logo/logo.gif';	

		$report->set_path_reporte($path);
		//Parametro para el titulo
		
		//Parametros para el encabezado del titulo
		$report->set_parametro('logo','S',$path_logo);
		//Paramentro del filtro
	
		//
		
		
		//Parametros para el usuario
		//$report->set_parametro('usuario','S',toba::usuario()->get_id());
		  	
		$db = toba::fuente('mupum')->get_db();
		$report->set_conexion($db);	
	}



	function enviar_correo_cancelacion($persona)
	{
		
		$user = $persona['nro_documento']; 
        $nombre = trim($persona['persona']);
        $atributos['email'] = $persona['correo'];

        //Armo el mail nuevo &oacute;
        $asunto = "Solicitud de Afiliacion Cancelada";
        $cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br>".
        				"<p>Por medio del presente le informamos que su Solicitud de Afiliacion a MUPUM ha sido cancelada.</p>".
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

	function enviar_correo_cancelacion_baja($persona)
	{
		
		$user = $persona['nro_documento']; 
        $nombre = trim($persona['persona']);
        $atributos['email'] = $persona['correo'];

        //Armo el mail nuevo &oacute;
        $asunto = "Solicitud de Baja de Afiliacion Cancelada";
        $cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br>".
        				"<p>Por medio del presente le informamos que su Solicitud de Baja de Afiliacion a MUPUM ha sido cancelada.</p>".
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

	function enviar_correo_aceptacion($persona)
	{
		
		$user = trim($persona['nro_documento']); 
	    $nombre = trim($persona['persona']);
	    $clave = toba_usuario::generar_clave_aleatoria(8);
	    $atributos['email'] = $persona['correo'];

	    if (toba::instancia()->es_usuario_bloqueado($user))
	    {
	    	toba::instancia()->desbloquear_usuario($user);
	    	toba_usuario::set_clave_usuario($clave, $user);

	    } else {
			
			$filtro['usuario'] = $user;
	    	$this->cn()->cargar_dt_usuario($filtro);
			$resultado = $this->cn()->existe_dt_usuario($filtro);
			if ($resultado == 'existe')
			{
				toba_usuario::set_clave_usuario($clave, $user);
			} else {
				toba::instancia()->agregar_usuario($user,$nombre,$clave,$atributos);
		        $perfil = 'afiliado';
			    toba::instancia()->vincular_usuario('mupum',$user,$perfil);
			}
	    	
	    }

	    //Armo el mail nuevo &oacute;
	    $asunto = "Solicitud Afiliacion Aceptada";
	    
		$cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br>".
				"<p>Por medio del presente le informamos que usted ha sido Afiliado correctamente.</p> ".
				"<p>Los datos para poder ingresar al sistema son:</p>".
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

	function enviar_correo_aceptacion_baja($persona)
	{
		
		$user = trim($persona['nro_documento']); 
	    $nombre = trim($persona['persona']);
	    $atributos['email'] = $persona['correo'];

	
		$filtro['usuario'] = $user;
    	$this->cn()->cargar_dt_usuario($filtro);
		$resultado = $this->cn()->existe_dt_usuario($filtro);
		if ($resultado == 'existe')
		{
			toba::instancia()->bloquear_usuario($user);		
		} 

	    //Armo el mail nuevo &oacute;
	    $asunto = "Baja de Afiliacion";
	  
	    
		$cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br>".
				"<p>Por medio del presente le informamos que usted ha sido Desafiliado correctamente de MUPUM.</p> ".
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

	//-----------------------------------------------------------------------------------
	//---- cuadro_cancelacion -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_cancelacion(ei_cuadro_cancelar_afiliacion $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{	
			$datos = dao::get_listado_cancelacion_afiliacion($this->s__where);
		}else{
			$datos = dao::get_listado_cancelacion_afiliacion();
		}
		$cuadro->set_datos($datos);
		$servicio = toba::memoria()->get_servicio_solicitado();
		
		if(($servicio == 'vista_pdf') or ($servicio == 'vista_excel'))
		{
			$columnas[] = 'fecha_alta';
			$columnas[] = 'fecha_baja';
			$columnas[] = 'solicitada';
			$columnas[] = 'activa';

			$cuadro->eliminar_columnas($columnas);		
		}
	}

	function evt__cuadro_cancelacion__activar($seleccion)
	{
		$this->cn()->cargar_dt_afiliacion($seleccion);
		$this->cn()->set_cursor_dt_afiliacion($seleccion);
		$this->set_pantalla('pant_aceptar_baja');
	}

	function evt__cuadro_cancelacion__baja($seleccion)
	{
		$this->cn()->cargar_dt_afiliacion($seleccion);
		$this->cn()->set_cursor_dt_afiliacion($seleccion);
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$this->s__persona = dao::get_listado_persona('persona.idpersona='.$datos['idpersona']);
			$this->enviar_correo_cancelacion_baja($this->s__persona[0]);
			
			$datos['solicita_cancelacion'] = 'f';
			$this->cn()->set_dt_afiliacion($datos);

		} else {
			$this->cn()->agregar_dt_afiliacion($datos);
		}
		
		try{
			$this->cn()->guardar_dt_afiliacion();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La afiliacion esta siendo referenciado, no puede eliminarlo",'error');
				
			} 	
			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');
				
			} 
						
		}
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
		
	}

	function evt__cuadro_cancelacion__seleccion($seleccion)
	{
		$this->cn()->cargar_dt_afiliacion($seleccion);
		$this->cn()->set_cursor_dt_afiliacion($seleccion);
		$this->set_pantalla('pant_edicion_baja');
	}

	//-----------------------------------------------------------------------------------
	//---- frm_aceptar_baja_afiliacion --------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_aceptar_baja_afiliacion(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$form->set_datos($datos);
		}
	}

	function evt__frm_aceptar_baja_afiliacion__procesar($datos)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$this->s__persona = dao::get_listado_persona('persona.idpersona='.$datos['idpersona']);
			$this->enviar_correo_aceptacion_baja($this->s__persona[0]);
			$datos['activa'] = 'f';
			$datos['solicita_cancelacion'] = 'f';
			$this->cn()->set_dt_afiliacion($datos);

		} else {
			$this->cn()->agregar_dt_afiliacion($datos);
		}
		
		try{
			$this->cn()->guardar_dt_afiliacion();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La afiliacion esta siendo referenciado, no puede eliminarlo",'error');
				
			} 	
			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');
				
			} 
						
		}
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}

	function evt__frm_aceptar_baja_afiliacion__cancelar()
	{
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}



	//-----------------------------------------------------------------------------------
	//---- frm_edicion_cancelar ---------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_edicion_cancelar(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$form->set_datos($datos);
		}
	}

	function evt__frm_edicion_cancelar__procesar($datos)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{

			$this->cn()->set_dt_afiliacion($datos);

		} else {
			$this->cn()->agregar_dt_afiliacion($datos);
		}
		
		try{
			$this->cn()->guardar_dt_afiliacion();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La afiliacion esta siendo referenciado, no puede eliminarlo",'error');
				
			} 	
			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');
				
			} 
						
		}
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}

	function evt__frm_edicion_cancelar__cancelar()
	{
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cuadro__nuevo($datos)
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro_cancelacion__nuevo($datos)
	{
		$this->set_pantalla('pant_edicion_baja');
	}

	

}
?>