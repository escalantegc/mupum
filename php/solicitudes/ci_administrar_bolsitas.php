<?php
require_once('dao.php');
class ci_administrar_bolsitas extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_bolsita();
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
		$this->cn()->resetear_dr_bolsita();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_bolsita();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_solicitudes -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_solicitudes(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_solicitudes_bolsita_escolar_administrar($this->s__where);
		}else{
			$datos = dao::get_listado_solicitudes_bolsita_escolar_administrar();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_solicitudes__ver($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_bolsita($seleccion);
		$this->cn()->set_cursor_dt_solicitud_bolsita($seleccion);
		$this->set_pantalla('pant_ver');
	}

	function evt__cuadro_solicitudes__aceptar($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_bolsita($seleccion);
		$this->cn()->set_cursor_dt_solicitud_bolsita($seleccion);
		$this->set_pantalla('pant_aceptar');
	}

	function evt__cuadro_solicitudes__rechazar($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_bolsita($seleccion);
		$this->cn()->set_cursor_dt_solicitud_bolsita($seleccion);
		$this->set_pantalla('pant_rechazar');
	}

	function evt__cuadro_solicitudes__revertir($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_bolsita($seleccion);
		$this->cn()->set_cursor_dt_solicitud_bolsita($seleccion);
		$this->set_pantalla('pant_revertir');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_solicitudes_historial -------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_solicitudes_historial(mupum_ei_cuadro $cuadro)
	{
		$cuadro->colapsar();
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_solicitudes_bolsita_escolar_historial($this->s__where);
		}else{
			$datos = dao::get_listado_solicitudes_bolsita_escolar_historial();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_solicitudes_historial__ver($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_bolsita($seleccion);
		$this->cn()->set_cursor_dt_solicitud_bolsita($seleccion);
		$this->set_pantalla('pant_ver');
	}

	function evt__cuadro_solicitudes_historial__revertir($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_bolsita($seleccion);
		$this->cn()->set_cursor_dt_solicitud_bolsita($seleccion);
		$datos['fecha_entrega'] = null;
		$datos['fecha_rechazo'] = null;
		$datos['entregado'] = null;

		$this->cn()->set_dt_solicitud_bolsita($datos);

		try{
			$this->cn()->guardar_dr_bolsita();
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
		$this->cn()->resetear_dr_bolsita();
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
		
		if($datos['entregado']['valor']=='true')
		{
			$datos['entregado']['valor'] = 1;	
		}
		if($datos['entregado']['valor']=='false')
		{
			$datos['entregado']['valor'] = 0;	
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
		if ($this->cn()->hay_cursor_dt_solicitud_bolsita())
		{
			$datos = $this->cn()->get_dt_solicitud_bolsita();
			$form->set_datos($datos);
		}
	}

	function evt__frm_aceptar__modificacion($datos)
	{
		$datos['entregado'] = 1;
		if ($this->cn()->hay_cursor_dt_solicitud_bolsita())
		{
			$this->cn()->set_dt_solicitud_bolsita($datos);
		} else {
			
			$this->cn()->agregar_dt_solicitud_bolsita($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_rechazar -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_rechazar(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_solicitud_bolsita())
		{
			$datos = $this->cn()->get_dt_solicitud_bolsita();
			$form->set_datos($datos);
		}
	}

	function evt__frm_rechazar__modificacion($datos)
	{
		$datos['entregado'] = 0;
		if ($this->cn()->hay_cursor_dt_solicitud_bolsita())
		{
			$this->cn()->set_dt_solicitud_bolsita($datos);
		} else {
			
			$this->cn()->agregar_dt_solicitud_bolsita($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ver ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ver(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_solicitud_bolsita())
		{
			$datos = $this->cn()->get_dt_solicitud_bolsita();
			$form->set_datos($datos);
		}
	}







}
?>