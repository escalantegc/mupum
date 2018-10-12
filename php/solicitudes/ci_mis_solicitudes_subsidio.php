<?php
require_once('dao.php');
class ci_mis_solicitudes_subsidio extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_subsidio();
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La solicitud de subsidio esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_descripcion'))
			{
				toba::notificacion()->agregar("La solicitud de subsidio ya esta registrado.",'info');
				
			} 
			
		}
		$this->cn()->resetear_dr_subsidio();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_subsidio();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_solicitud_subsidio($this->s__where);
		}else{
			$datos = dao::get_listado_solicitud_subsidio();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_subsidio($seleccion);
		$this->cn()->set_cursor_dt_solicitud_subsidio($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_subsidio($seleccion);
		$this->cn()->set_cursor_dt_solicitud_subsidio($seleccion);
		$datos = $this->cn()->get_dt_solicitud_subsidio();

		$socio = dao::get_datos_persona_afiliada($datos['idafiliacion']);
		$tipo_subsidio = dao::get_listado_tipo_subsidio('idtipo_subsidio = '.$datos['idtipo_subsidio']);
		$datos_correo['tipo_subsidio']= $tipo_subsidio[0]['descripcion'];
	   	$datos_correo['monto'] = $datos['monto'];
	    $datos_correo['socio'] = $socio[0]['persona'];
	    $datos_correo['correo'] = $socio[0]['correo'];
	    

		$this->cn()->eliminar_dt_solicitud_subsidio($seleccion);
		try{
			$this->enviar_correo_baja_solicitud_subsidio($datos_correo);
			$this->cn()->guardar_dr_subsidio();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La solicitud de subsidio esta siendo referenciado, no puede eliminarlo",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_subsidio();
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
			$this->s__where = $filtro->get_sql_where();
			
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
		if ($this->cn()->hay_cursor_dt_solicitud_subsidio())
		{
			$datos = $this->cn()->get_dt_solicitud_subsidio();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_solicitud_subsidio())
		{
			$this->cn()->set_dt_solicitud_subsidio($datos);
		} else {
			$datos['fecha_solicitud'] = date('Y-m-j');
			$this->cn()->agregar_dt_solicitud_subsidio($datos);
		}

		$socio = dao::get_datos_persona_afiliada($datos['idafiliacion']);
		$tipo_subsidio = dao::get_listado_tipo_subsidio('idtipo_subsidio = '.$datos['idtipo_subsidio']);
		$datos_correo['tipo_subsidio']= $tipo_subsidio[0]['descripcion'];
	   	$datos_correo['monto'] = $datos['monto'];
	    $datos_correo['socio'] = $socio[0]['persona'];
	    $datos_correo['correo'] = $socio[0]['correo'];
	    $this->enviar_correo_solicitud_subsidio($datos_correo);
	}



	function enviar_correo_solicitud_subsidio($datos)
	{
	    $tipo = $datos['tipo_subsidio'];
	    $monto = $datos['monto'];
	    $socio = $datos['socio'];

	    //Armo el mail nuevo &oacute;
	    $asunto = "Constancia de Solicitud de Subsidio ";
	    
		$cuerpo_mail = "Por medio del presente se deja Constancia de la Solicitud de Subsidio.<br/> ".
				"Los datos de la solicitud son:<br/>".
				"Socio Titular: ".$socio. "<br/>".
				"Tipo Subsidio: ".$tipo. "<br/>".
				"Monto: $". $monto. "<br/>".
				"<b>IMPORTANTE : Para acceder al beneficio deberá presentar la siguiente documentación: <br/ >
				Certificado de nacimiento vivo o de casamiento y nota de solicitud del subsidio para archivo.</b> <br/>".
				"<p>No responda este correo, fue generado por sistema. </p>";

        try 
        {
            $mail = new toba_mail('escalantegc@gmail.com', $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
            $mail->set_html(true);
            $cc[] = trim($datos['correo']);
            $mail->set_cc($cc);
            $mail->enviar();
        } catch (toba_error $error) {
            $chupo = $error->get_mensaje_log();
            toba::notificacion()->agregar($chupo, 'info');
        }
	}	


	function enviar_correo_baja_solicitud_subsidio($datos)
	{
	    $tipo = $datos['tipo_subsidio'];
	    $monto = $datos['monto'];
	    $socio = $datos['socio'];

	    //Armo el mail nuevo &oacute;
	    $asunto = "Constancia de Baja de Solicitud de Subsidio ";
	    
		$cuerpo_mail = "Por medio del presente se deja Constancia de la Baja de  Solicitud de Subsidio.<br/> ".
				"Los datos de la solicitud son:<br/>".
				"Socio Titular: ".$socio. "<br/>".
				"Tipo Subsidio: ".$tipo. "<br/>".
				"Monto: $". $monto. "<br/>".
				"<p>No responda este correo, fue generado por sistema. </p>";

        try 
        {
            $mail = new toba_mail('escalantegc@gmail.com', $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
            $mail->set_html(true);
            $cc[] = trim($datos['correo']);
            $mail->set_cc($cc);
            $mail->enviar();
        } catch (toba_error $error) {
            $chupo = $error->get_mensaje_log();
            toba::notificacion()->agregar($chupo, 'info');
        }
	}


}
?>