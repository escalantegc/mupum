<?php
require_once('dao.php');
class ci_seleccion_persona_externa extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_socio();
			
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_documento'))
			{
				toba::notificacion()->agregar("La afiliacion ya esta registrada.",'info');
			} 		

			if(strstr($mensaje_log,'idx_legajo'))
			{
				toba::notificacion()->agregar("El socio ya esta registrado.",'info');
			} 		
		}

		$this->cn()->resetear_dr_socio();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_socio();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		$cuadro->desactivar_modo_clave_segura();
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_persona_externa($this->s__where);
			$cuadro->set_datos($datos);
		}
	}

	function evt__cuadro__editar($seleccion)
	{
		$this->cn()->cargar_dr_socio($seleccion);
		$this->cn()->set_cursor_dt_persona($seleccion);
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

	function conf__frm(ei_frm_persona_popup $form)
	{
		if ($this->cn()->hay_cursor_dt_persona())
		{
			$datos = $this->cn()->get_dt_persona();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_persona())
		{
			$this->cn()->set_dt_persona($datos);
		} else {
			$this->cn()->agregar_dt_persona($datos);
		}
		$filtro_forzado['nro_documento']['condicion'] = 'es_igual_a';
		$filtro_forzado['nro_documento']['valor'] = $datos['nro_documento'];
		$this->evt__filtro__filtrar($filtro_forzado);
	}

}

?>