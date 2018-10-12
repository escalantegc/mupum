<?php
require_once('dao.php');
class ci_administrar_solicitudes_subsidios extends mupum_ci
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

	function evt__cuadro__ver($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_subsidio($seleccion);
		$this->cn()->set_cursor_dt_solicitud_subsidio($seleccion);
		$this->set_pantalla('pant_ver');
	}

	function evt__cuadro__aceptar($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_subsidio($seleccion);
		$this->cn()->set_cursor_dt_solicitud_subsidio($seleccion);
		$this->set_pantalla('pant_aceptar');
	}

	function evt__cuadro__rechazar($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_subsidio($seleccion);
		$this->cn()->set_cursor_dt_solicitud_subsidio($seleccion);
		$this->set_pantalla('pant_rechazar');
	}
	function evt__cuadro__revertir($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_subsidio($seleccion);
		$this->cn()->set_cursor_dt_solicitud_subsidio($seleccion);
		$datos['fecha_pago'] = null;
		$datos['pagado'] = null;

		$this->cn()->set_dt_solicitud_subsidio($datos);

		try{
			$this->cn()->guardar_dr_subsidio();
			if (!toba::notificacion()->verificar_mensajes())
			{
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			}
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
		 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_solicitud_bolsita'))
			{
				toba::notificacion()->agregar("Solo puede realizar una solicitud de bolsita escolar por a&#241;o por familiar.",'info');
				
			} 
			
		}
		$this->cn()->resetear_dr_subsidio();
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
			if (strstr($this->s__where, "pagado = 'null'"))
			{
				$this->s__where = str_replace("pagado = 'null'", "pagado is null", $this->s__where);
			}
		}
	}

	function evt__filtro__filtrar($datos)
	{
		if($datos['pagado']['valor']=='true')
		{
			$datos['pagado']['valor'] = 1;	
		}
		if($datos['pagado']['valor']=='false')
		{
			$datos['pagado']['valor'] = 0;	
		}

		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- frm_aceptar ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_aceptar(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_solicitud_subsidio())
		{
			$datos = $this->cn()->get_dt_solicitud_subsidio();
			$form->set_datos($datos);
		}
	}

	function evt__frm_aceptar__modificacion($datos)
	{
		$datos['fecha_pago'] = date('Y-m-j');
		$datos['pagado'] = 1;
		if ($this->cn()->hay_cursor_dt_solicitud_subsidio())
		{
			$this->cn()->set_dt_solicitud_subsidio($datos);
		} else {
			
			$this->cn()->agregar_dt_solicitud_subsidio($datos);
		}

		$socio = dao::get_datos_persona_afiliada($datos['idafiliacion']);
		$tipo_subsidio = dao::get_listado_tipo_subsidio('idtipo_subsidio = '.$datos['idtipo_subsidio']);
		$datos_correo['tipo_subsidio']= $tipo_subsidio[0]['descripcion'];
	   	$datos_correo['monto'] = $datos['monto'];
	    $datos_correo['socio'] = $socio[0]['persona'];
	    $datos_correo['correo'] = $socio[0]['correo'];
	    $this->enviar_correo_aceptar_solicitud_subsidio($datos_correo);
	}

	//-----------------------------------------------------------------------------------
	//---- frm_rechazar -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_rechazar(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_solicitud_subsidio())
		{
			$datos = $this->cn()->get_dt_solicitud_subsidio();
			$form->set_datos($datos);
		}
	}

	function evt__frm_rechazar__modificacion($datos)
	{
		$datos['pagado'] = 0;
		if ($this->cn()->hay_cursor_dt_solicitud_subsidio())
		{
			$this->cn()->set_dt_solicitud_subsidio($datos);
		} else {
			
			$this->cn()->agregar_dt_solicitud_subsidio($datos);
		}

		$socio = dao::get_datos_persona_afiliada($datos['idafiliacion']);
		$tipo_subsidio = dao::get_listado_tipo_subsidio('idtipo_subsidio = '.$datos['idtipo_subsidio']);
		$datos_correo['tipo_subsidio']= $tipo_subsidio[0]['descripcion'];
	   	$datos_correo['monto'] = $datos['monto'];
	    $datos_correo['socio'] = $socio[0]['persona'];
	    $datos_correo['correo'] = $socio[0]['correo'];
	    $this->enviar_correo_rechazar_solicitud_subsidio($datos_correo);
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ver ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ver(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_solicitud_subsidio())
		{
			$datos = $this->cn()->get_dt_solicitud_subsidio();
			$form->set_datos($datos);
		}
	}




	function enviar_correo_aceptar_solicitud_subsidio($datos)
	{
	    $tipo = $datos['tipo_subsidio'];
	    $monto = $datos['monto'];
	    $socio = $datos['socio'];

	    //Armo el mail nuevo &oacute;
	    $asunto = "Solicitud de Subsidio Aceptada";
	    
		$cuerpo_mail = "Por medio del presente le informamos que la Solicitud de Subsidio con los datos.<br/> ".
				"Socio Titular: ".$socio. "<br/>".
				"Tipo Subsidio: ".$tipo. "<br/>".
				"Monto: $". $monto. "<br/>".
				 "Ha sido Aceptada, puede acercarse a las instalaciones de la mutual o llamar por telefono para coordinar el pago.<br/>".
				"<p>No responda este correo, fue generado por sistema. </p>";

        
        try 
        {
            $mail = new toba_mail(trim($datos['correo']), $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
            $mail->set_html(true);
            $cc[] = 'escalantegc@gmail.com';
            $mail->set_cc($cc);
            $mail->enviar();
        } catch (toba_error $error) {
            $chupo = $error->get_mensaje_log();
            toba::notificacion()->agregar($chupo, 'info');
        }
	}

	function enviar_correo_rechazar_solicitud_subsidio($datos)
	{
	    $tipo = $datos['tipo_subsidio'];
	    $monto = $datos['monto'];
	    $socio = $datos['socio'];

	    //Armo el mail nuevo &oacute;
	    $asunto = "Solicitud de Subsidio Rechazada";
	    
		$cuerpo_mail = "Por medio del presente le informamos que la Solicitud de Subsidio con los datos.<br/> ".
				"Socio Titular: ".$socio. "<br/>".
				"Tipo Subsidio: ".$tipo. "<br/>".
				"Monto: $". $monto. "<br/>".
				"Ha sido rechazada, cualquier duda comuniquese con la Comision Directiva.<br/>".
				"<p>No responda este correo, fue generado por sistema. </p>";

        
        try 
        {
            $mail = new toba_mail(trim($datos['correo']), $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
            $mail->set_html(true);
            $cc[] = 'escalantegc@gmail.com';
            $mail->set_cc($cc);
            $mail->enviar();
        } catch (toba_error $error) {
            $chupo = $error->get_mensaje_log();
            toba::notificacion()->agregar($chupo, 'info');
        }
	}

}
?>