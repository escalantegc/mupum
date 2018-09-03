<?php
require_once('dao.php');
class ci_inscripcion_colonos extends mupum_ci
{
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
				toba::notificacion()->agregar("La solicitud de subsidio esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_descripcion'))
			{
				toba::notificacion()->agregar("La solicitud de subsidio ya esta registrado.",'info');
				
			} 
			
		}
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_inscripcion_colono($this->s__where);
		}else{
			$datos = dao::get_listado_inscripcion_colono();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_colonia($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_colono($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_colonia($seleccion);
		$this->cn()->eliminar_dt_inscripcion_colono($seleccion);
		try{
			$this->cn()->guardar_dr_colonia();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La solicitud de subsidio esta siendo referenciado, no puede eliminarlo",'error');
				
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
		if ($this->cn()->hay_cursor_dt_inscripcion_colono())
		{
			$datos = $this->cn()->get_dt_inscripcion_colono();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_inscripcion_colono())
		{
			$this->cn()->set_dt_inscripcion_colono($datos);
		} else {
			$datos['fecha'] = date('Y-m-j');
			$this->cn()->agregar_dt_inscripcion_colono($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_telefonos_contacto -------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_telefonos_contacto(mupum_ei_formulario_ml $form_ml)
	{
		return $this->cn()->get_dt_telefono_inscripcion_colono();
	}

	function evt__frm_telefonos_contacto__modificacion($datos)
	{
		$this->cn()->procesar_dt_telefono_inscripcion_colono($datos);
	}

}
?>