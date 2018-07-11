<?php
require_once('dao.php');
class ci_motivo_por_tipo_socio extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_parametros();
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La configuracion estado esta siendo referenciada, no puede eliminarla",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_motivo_por_tipo_socio'))
			{
				toba::notificacion()->agregar("La configuracion de la reserva ya esa registrada. No puede tener mas de una configuracion de reserva con el mismo tipo de socio, motivo e instalacion..",'info');
			} 
			
		}
		$this->cn()->resetear_dr_parametros();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_parametros();
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
			$datos = dao::get_listado_motivo_por_tipo_socio($this->s__where);
		}else{
			$datos = dao::get_listado_motivo_por_tipo_socio();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dt_motivo_tipo_socio($seleccion);
		$this->cn()->set_cursor_dt_motivo_tipo_socio($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dt_motivo_tipo_socio($seleccion);
		$this->cn()->eliminar_dt_motivo_tipo_socio($seleccion);
		try{
			$this->cn()->guardar_dr_parametros();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La configuracion estado esta siendo referenciada, no puede eliminarla",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_parametros();
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
		if ($this->cn()->hay_cursor_dt_motivo_tipo_socio())
		{
			$datos = $this->cn()->get_dt_motivo_tipo_socio();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_motivo_tipo_socio())
		{
			$this->cn()->set_dt_motivo_tipo_socio($datos);
		} else {
			$this->cn()->agregar_dt_motivo_tipo_socio($datos);
		}
	}

}

?>