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

	function evt__volver()
	{
		$this->get_cn()->resetear_cursor_dt_afiliacion();
		$this->set_pantalla('pant_inicial');
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


	function evt__cuadro__cancelar($seleccion)
	{
		$this->get_cn()->set_cursor_dt_afiliacion($seleccion);
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
			$datos['fecha_solicitud_cancelacion'] =  date("Y-m-d"); 
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->get_cn()->hay_cursor_dt_afiliacion($datos))
		{
			$datos['solicita_cancelacion'] = 't';
			$this->get_cn()->set_dt_afiliacion($datos);

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