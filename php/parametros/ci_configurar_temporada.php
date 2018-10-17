<?php
require_once('dao.php');
class ci_configurar_temporada extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
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
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La temporada de pileta esta siendo referenciado, no puede eliminarla",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_temporada_pileta'))
			{
				toba::notificacion()->agregar("Ya existe la temporada de pileta que desea configurar.",'info');
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
			$datos = dao::get_listado_temporada_pileta($this->s__where);
		}else{
			$datos = dao::get_listado_temporada_pileta();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->set_cursor_dt_temporada_pileta($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{	
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->eliminar_dt_temporada_pileta($seleccion);
		try{
			$this->cn()->guardar_dr_pileta();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La temporada de pileta esta siendo referenciado, no puede eliminarla",'error');
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

	function conf__frm(ei_frm_temporada_pileta $form)
	{		
		if ($this->cn()->hay_cursor_dt_temporada_pileta())
		{
			$datos = $this->cn()->get_dt_temporada_pileta();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_temporada_pileta())
		{
			$this->cn()->set_dt_temporada_pileta($datos);
		} else {
			$this->cn()->agregar_dt_temporada_pileta($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_costos ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_costos(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_costo_pileta_tipo_socios();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_costos__modificacion($datos)
	{
		$this->cn()->procesar_dt_costo_pileta_tipo_socio($datos);
	}

}

?>