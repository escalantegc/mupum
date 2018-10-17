<?php
require_once('dao.php');
class ci_talonario_bonos extends mupum_ci
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
				toba::notificacion()->agregar("El talonario de bono esta siendo referenciado, no puede eliminarlo",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_talonario'))
			{
				toba::notificacion()->agregar("El numero de talonario de bono ya esta registrado",'error');
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
			$datos = dao::get_listado_talonario_bono($this->s__where);
		}else{
			$datos = dao::get_listado_talonario_bono();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dt_talonario_bono($seleccion);
		$this->cn()->set_cursor_dt_talonario_bono($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
				$this->cn()->cargar_dt_talonario_bono($seleccion);
		$this->cn()->eliminar_dt_talonario_bono($seleccion);
		try{
			$this->cn()->guardar_dr_convenio();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El talonario de bono esta siendo referenciado, no puede eliminarlo",'error');
				
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
				if ($this->cn()->hay_cursor_dt_talonario_bono())
		{
			$datos = $this->cn()->get_dt_talonario_bono();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
				if ($this->cn()->hay_cursor_dt_talonario_bono())
		{
			$this->cn()->set_dt_talonario_bono($datos);
		} else {
			$this->cn()->agregar_dt_talonario_bono($datos);
		}
	}

}

?>