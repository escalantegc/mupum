<?php
class ci_administrar_inscripciones extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_pileta();
			
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'inscripcion_pileta_idtemporada_pileta_idafiliacion_idx'))
			{
				toba::notificacion()->agregar("Su grupo familiar ya se encuentra inscripto, si desea agregar mas personas al grupo debe editar la inscripcion..",'info');
	
			} 
			
		}
		$this->cn()->resetear_dr_pileta();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_pileta();
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
			$datos = dao::get_listado_inscripcion_pileta($this->s__where);
		}else{
			$datos = dao::get_listado_inscripcion_pileta();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_pileta($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_pileta($seleccion);
		$this->cn()->eliminar_dt_inscripcion_pileta($seleccion);
		try{
			

			$this->cn()->guardar_dr_pileta();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("No puede borrar al inscripcion del grupo familiar.",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_pileta();
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

	function conf__frm(ei_frm_pileta $form)
	{
		if ($this->cn()->hay_cursor_dt_inscripcion_pileta())
		{
			$datos = $this->cn()->get_dt_inscripcion_pileta();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{	
		if ($this->cn()->hay_cursor_dt_inscripcion_pileta())
		{
			$this->cn()->set_dt_inscripcion_pileta($datos);
		} else {
			$datos['fecha'] = date('Y-m-j');
			$this->cn()->agregar_dt_inscripcion_pileta($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_detalle_pago_pileta ---------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_detalle_pago_pileta(ei_frm_detalle_pago_pileta $form_ml)
	{
		return $this->cn()->get_dt_detalle_pago_inscripcion_pileta();
	}

	function evt__frm_ml_detalle_pago_pileta__modificacion($datos)
	{
		$this->cn()->procesar_dt_detalle_pago_inscripcion_pileta($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_grupo_familiar --------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_grupo_familiar(eI_frm_ml_grupo_familiar $form_ml)
	{
		return $this->cn()->get_dt_detalle_inscripcion_pileta();
	}

	function evt__frm_ml_grupo_familiar__modificacion($datos)
	{
		$this->cn()->procesar_dt_detalle_inscripcion_pileta($datos);
	}

}

?>