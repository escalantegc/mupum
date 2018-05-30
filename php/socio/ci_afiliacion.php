<?php
class ci_afiliacion extends mupum_ci
{
	function get_cn()
	{
		return $this->controlador->cn();
	}
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		$persona = $this->get_cn()->get_dt_persona();
		
		if(isset($this->s__datos_filtro))
		{	
			$where = $this->s__where.' and afiliacion.idpersona ='.$persona['idpersona'];
			$datos = dao::get_listado_afiliacion($where);
		}else{
			$where = ' afiliacion.idpersona ='.$persona['idpersona'];
			$datos = dao::get_listado_afiliacion($where);
			
		}
		if (is_array($datos))
		{
			$cuadro->set_datos($datos);
		}
		
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->get_cn()->set_cursor_dt_afiliacion($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		
		$this->get_cn()->eliminar_dt_afiliacion($seleccion);
		try{
			$this->get_cn()->cargar_dr_socio();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La afiliacion esta siendo referenciada, no puede eliminarla",'error');
				
			} 		
		}
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
		if ($this->get_cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->get_cn()->get_dt_afiliacion();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->get_cn()->hay_cursor_dt_afiliacion())
		{
			
			$this->get_cn()->resetear_cursor_dt_afiliacion();

		} else {
			$this->get_cn()->agregar_dt_afiliacion($datos);
		}
	}

	function get_estados_segun_categoria()
	{
		return dao::get_listado_estado('AFILIACION');

	}

}

?>