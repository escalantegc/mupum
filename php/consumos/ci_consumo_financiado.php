<?php
class ci_consumo_financiado extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		$this->cn()->guardar_dr_consumo_financiado();
		try{
			
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El consumo del bono  esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_consumo'))
			{
				toba::notificacion()->agregar("El consumo del bono esta registrado.",'info');
				
			} 
			
		}
		$this->cn()->resetear_dr_consumo_financiado();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_consumo_financiado();
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
			$datos = dao::get_listado_consumos_financiado($this->s__where);
		}else{
			$datos = dao::get_listado_consumos_financiado();
		}
		
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_consumo_financiado($seleccion);
		$this->cn()->set_cursor_dt_consumo_financiado($seleccion);
		$this->set_pantalla('pant_edicion');
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
		if ($this->cn()->hay_cursor_dt_consumo_financiado())
		{
			$datos = $this->cn()->get_dt_consumo_financiado();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_consumo_financiado())
		{
			$this->cn()->set_dt_consumo_financiado($datos);
		} else {
			$this->cn()->agregar_dt_consumo_financiado($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_detalle_consumo -------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_detalle_consumo(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_cuotas_consumo_financiado();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_detalle_consumo__modificacion($datos)
	{
		$this->cn()->procesar_dt_cuotas_consumo_financiado($datos);
	}

}
?>