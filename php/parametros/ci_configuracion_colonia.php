<?php
require_once('dao.php');
class ci_configuracion_colonia extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{

		try{
			$this->cn()->guardar_dr_colonia();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La colonia esta siendo referenciado, no puede eliminarla",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_anio_colonia'))
			{
				toba::notificacion()->agregar("Ya tiene una colonia configurada para este a&#241;o.",'info');
			} 
			
		}
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_colonia();
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
			$datos = dao::get_listado_configuracion_colonia($this->s__where);
		}else{
			$datos = dao::get_listado_configuracion_colonia();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_colonia($seleccion);
		$this->cn()->set_cursor_dt_configuracion_colonia($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_colonia($seleccion);
		$this->cn()->eliminar_dt_configuracion_colonia($seleccion);
		try{
			$this->cn()->guardar_dr_colonia();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El tipo de subsidio esta siendo referenciado, no puede eliminarlo",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_colonia();
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
		if ($this->cn()->hay_cursor_dt_configuracion_colonia())
		{
			$datos = $this->cn()->get_dt_configuracion_colonia();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_configuracion_colonia())
		{
			$this->cn()->set_dt_configuracion_colonia($datos);
		} else {
			$this->cn()->agregar_dt_configuracion_colonia($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_costo_colonia_tipo_socios();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml__modificacion($datos)
	{
		$this->cn()->procesar_dt_costo_colonia_tipo_socio($datos);
	}

}
?>