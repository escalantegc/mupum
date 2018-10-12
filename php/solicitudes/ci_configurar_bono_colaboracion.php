<?php
require_once('dao.php');
class ci_configurar_bono_colaboracion extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{

		try{
			$this->cn()->guardar_dr_bono_colaboracion();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El el talonario de bono esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'talonario_bono_colaboracion_descripcion_idx'))
			{
				toba::notificacion()->agregar("El talonario de bono ya esta registrado.",'info');
				
			} 
			
		}
		$this->cn()->resetear_dr_bono_colaboracion();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_bono_colaboracion();
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
			$datos = dao::get_listado_talonario_bono_colaboracion($this->s__where);
		}else{
			$datos = dao::get_listado_talonario_bono_colaboracion();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_bono_colaboracion($seleccion);
		$this->cn()->set_cursor_dt_talonario_bono_colaboracion($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_bono_colaboracion($seleccion);
		$this->cn()->eliminar_dt_talonario_bono_colaboracion($seleccion);
		try{
			$this->cn()->guardar_dr_bono_colaboracion();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El el talonario de bono esta siendo referenciado, no puede eliminarlo",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_bono_colaboracion();
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
		if ($this->cn()->hay_cursor_dt_talonario_bono_colaboracion())
		{
			$datos = $this->cn()->get_dt_talonario_bono_colaboracion();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_talonario_bono_colaboracion())
		{
			$this->cn()->set_dt_talonario_bono_colaboracion($datos);
		} else {
			$this->cn()->agregar_dt_talonario_bono_colaboracion($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_premios ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_premios(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_premio_sorteo();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_premios__modificacion($datos)
	{
		$this->cn()->procesar_dt_premio_sorteo($datos);
	}

}

?>