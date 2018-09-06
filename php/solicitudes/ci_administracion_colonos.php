<?php
class ci_administracion_colonos extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_colonos_del_afiliado($this->s__where);
		}else{
			$datos = dao::get_colonos_del_afiliado();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{	
		$this->cn()->cargar_dr_administrar_colonia($seleccion);
		$this->cn()->set_cursor_dt_afiliacion_colonia($seleccion);
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
	//---- frm_ml_colonos ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_colonos(mupum_ei_formulario_ml $form_ml)
	{
		return $this->cn()->get_dt_inscripcion_colonos();
	}

	function evt__frm_ml_colonos__modificacion($datos)
	{
		$this->cn()->procesar_dt_inscripcion_colonos($datos);
	}

}
?>