<?php
require_once('dao.php');
class ci_configuracion_convenios extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{

		try{
			$this->cn()->guardar_dr_convenio();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La configuracion del convenio esta siendo referenciada, no puede eliminarla",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_convenio'))
			{
				toba::notificacion()->agregar("La configuracion del convenio ya esa registrada. ",'info');
			} 
			
		}
		$this->cn()->resetear_dr_convenio();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_convenio();
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
			$datos = dao::get_listado_convenios($this->s__where);
		}else{
			$datos = dao::get_listado_convenios();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_convenio($seleccion);
		$this->cn()->set_cursor_dt_convenio($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_convenio($seleccion);
		$this->cn()->eliminar_dt_convenio($seleccion);
		try{
			$this->cn()->guardar_dr_convenio();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La configuracion del convenio esta siendo referenciada, no puede eliminarla",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_convenio();
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
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_convenio())
		{
			$datos = $this->cn()->get_dt_convenio();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_convenio())
		{
			$this->cn()->set_dt_convenio($datos);
		} else {
			$this->cn()->agregar_dt_convenio($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_comercios_por_convenios -----------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_comercios_por_convenios(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_comercios_por_convenio();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_comercios_por_convenios__modificacion($datos)
	{
		$this->cn()->procesar_dt_comercios_por_convenio($datos);
	}

}

?>