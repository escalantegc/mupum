<?php
require_once('dao.php');
class ci_reempadronamiento extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_reempadronamiento();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El reempadronamiento esta siendo referenciado, no puede eliminarla",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_reempadronamiento'))
			{
				toba::notificacion()->agregar("La reempadronamiento ya esa registrado. ",'info');
			} 
			
		}
		$this->cn()->resetear_dr_reempadronamiento();
		$this->set_pantalla('pant_inicial');
		
	}

	function evt__nuevo()
	{
		$cantidad = dao::get_cantidad_solicitudes_no_atendidas();
		if ($cantidad >0)
		{
			toba::notificacion()->agregar("No puede crear otra solicitud de reempadronamiento, hay solicitudes pendientes de ser atendidas",'info');
		} else {
			$this->set_pantalla('pant_edicion');
		}
		
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_reempadronamiento();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_reempadronamiento($this->s__where);
		}else{
			$datos = dao::get_listado_reempadronamiento();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_reempadronamiento($seleccion);
		$this->cn()->set_cursor_dt_reempadronamiento($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	function evt__cuadro__notificar($seleccion)
	{
		$this->set_pantalla('pant_notificaciones');
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro_solicitudes -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_solicitudes(mupum_ei_cuadro $cuadro)
	{
		$datos = dao::get_listado_solicitudes_reempadronamientos();
		$cuadro->set_datos($datos);
		if ($datos ==null)
		{
			$this->evento('enviar')->ocultar();
		}
	}

	function evt__cuadro_solicitudes__seleccion($datos)
	{
		///escribir codigo para enviar mails y editar los registros colocando notificaciones en 1 y fecha de notificacion hoy
		foreach ($datos as $dato) 
		{
			$correos[] = dao::get_correo_persona($dato['idpersona']);
			$solicitud['idreempadronamiento'] = $dato['idreempadronamiento'];
			$solicitud['idafiliacion'] = $dato['idafiliacion'];
		
			$this->cn()->set_cursor_dt_solicitud_reempadronamiento($solicitud);			
			$solicitud['notificaciones'] += 1;
			$solicitud['fecha_notificacion'] = date('d-m-Y');
			$this->cn()->set_dt_solicitud_reempadronamiento($solicitud);
				
			$this->cn()->resetear_cursor_dt_solicitud_reempadronamiento();
			$solicitud = null;
			
		}

		$reempadronamiento = $this->cn()->get_dt_reempadronamiento();
		
		$asunto = 'Solicitud Reempadronamiento - '.$reempadronamiento['anio'];
		$this->enviar_correo_notificacion($correos,$asunto);
		try{
			$this->cn()->guardar_dr_reempadronamiento();
			toba::notificacion()->agregar("Las solicitudes han sido enviadas correctamente",'info');
		} catch( toba_error_db $error){
	
			$mensaje_log = $error->get_mensaje_log();
			toba::notificacion()->agregar($mensaje_log,'info');
			 
			
		}
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_solicitudes_enviadas --------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_solicitudes_enviadas(mupum_ei_cuadro $cuadro)
	{
	
		$datos = dao::get_listado_solicitudes_reempadronamientos_enviadas();
		$cuadro->set_datos($datos);
	}
	
	function evt__cuadro_solicitudes_enviadas__notificar($seleccion)
	{
		$correos[] = dao::get_correo_persona($seleccion['idpersona']);
		$solicitud['idreempadronamiento'] = $seleccion['idreempadronamiento'];
		$solicitud['idafiliacion'] = $seleccion['idafiliacion'];
	
		$this->cn()->set_cursor_dt_solicitud_reempadronamiento($solicitud);			
		
		$enviada = $this->cn()->get_dt_solicitud_reempadronamiento();
		$solicitud['notificaciones'] = $enviada['notificaciones']+1;
		$solicitud['fecha_notificacion'] = date('d-m-Y');
		$this->cn()->set_dt_solicitud_reempadronamiento($solicitud);
		

		$this->cn()->resetear_cursor_dt_solicitud_reempadronamiento();
		$solicitud = null;

		$reempadronamiento = $this->cn()->get_dt_reempadronamiento();
		
		$asunto = 'Solicitud Reempadronamiento - '.$reempadronamiento['anio'];
		$this->enviar_correo_notificacion($correos,$asunto);
		try{
			$this->cn()->guardar_dr_reempadronamiento();
			toba::notificacion()->agregar("La solicitud han sido enviadas correctamente",'info');
		} catch( toba_error_db $error){
	
			$mensaje_log = $error->get_mensaje_log();
			toba::notificacion()->agregar($mensaje_log,'info');
			 
			
		}

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
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_reempadronamiento())
		{
			$datos = $this->cn()->get_dt_reempadronamiento();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_reempadronamiento())
		{
			$this->cn()->set_dt_reempadronamiento($datos);
		} else {
			$this->cn()->agregar_dt_reempadronamiento($datos);
		}
	}

	function enviar_correo_notificacion($correos,$asunto)
	{
        //Armo el mail nuevo &oacute;

        $cuerpo_mail = "<p>Estimado afiliado: </p><br>".
        				"Por medio del presente le solicitamos realice el reempadronamiento actualizando su información personal<br>".
        				"(pestaña “Datos Personales” de su ficha) en el sistema. Una vez realizado lo solicitado confirmar la acción<br>".
        				"chequeando el campo “Reempadronamiento realizado” al final del formulario y presionar el botón “Guardar”<br>".
           				"<p>Saludos ATTE .- MUPUM</p>".
          				"<p>No responda este correo, fue generado por sistema. </p>";
        try 
        {
                $mail = new toba_mail($correos[0], $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
                $mail->set_html(true);
                $mail->set_cc($correos);
                $mail->enviar();
        } catch (toba_error $error) {
                $chupo = $error->get_mensaje_log();
                toba::notificacion()->agregar($chupo, 'info');
        }
	}





}
?>