<?php
class ci_solicitar_ayuda_economica extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_consumo_convenio();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El consumo por ticket  esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_consumo_convenio'))
			{
				toba::notificacion()->agregar("El consumo del ticket ya esta registrado.",'info');
				
			}  else {

				toba::notificacion()->agregar($mensaje_log,'error');
			}
			
		}
		$this->cn()->resetear_dr_consumo_convenio();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_consumo_convenio();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$conf = dao::get_configuracion();
		$minimo = dao::get_minimo_coutas_para_pedir_otra_ayuda();

	
		$diahoy = date("d"); 

		if ((int)$diahoy > (int) $conf['fecha_limite_pedido_convenio'])
		{
			toba::notificacion()->agregar("Puede solicitar ayuda economica solamente hasta el: ".$conf['fecha_limite_pedido_convenio']. " del mes." ,'info');
		} else {
			$this->set_pantalla('pant_edicion');	
		}



		
	}	

	function evt__nuevo_libre()
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
			$datos = dao::get_listado_ayuda_economica($this->s__where);
		}else{
			$datos = dao::get_listado_ayuda_economica();
		}
		
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_consumo_convenio($seleccion);
		$this->cn()->set_cursor_dt_consumo_convenio($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	
	function evt__cuadro__ver($seleccion)
	{
		$this->cn()->cargar_dr_consumo_convenio($seleccion);
		$this->cn()->set_cursor_dt_consumo_convenio($seleccion);
		$this->set_pantalla('pantalla_ver');
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

		if ($this->cn()->hay_cursor_dt_consumo_convenio())
		{
			$datos = $this->cn()->get_dt_consumo_convenio();
			$datos['fecha'] = date("d-m-Y");   
			$form->set_datos($datos);
		}
		$datos['fecha'] = date("Y-m-d");   
			$form->set_datos($datos);
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_consumo_convenio())
		{
			$this->cn()->set_dt_consumo_convenio($datos);
		} else {
			$this->cn()->agregar_dt_consumo_convenio($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_detalle_ayuda ---------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_detalle_ayuda(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_consumo_convenio_cuotas();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_detalle_ayuda__modificacion($datos)
	{
		$this->cn()->procesar_dt_consumo_convenio_cuotas($datos);
	}



	//-----------------------------------------------------------------------------------
	//---- frm_ml_detalle_ayuda_ver -----------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_detalle_ayuda_ver(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_consumo_convenio_cuotas();
		$form_ml->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ver ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ver(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_consumo_convenio())
		{
			$datos = $this->cn()->get_dt_consumo_convenio();
			$form->set_datos($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ayuda_mutual -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ayuda_mutual(ei_frm_ayuda_economica $form)
	{
		if ($this->cn()->hay_cursor_dt_consumo_convenio())
		{
			$datos = $this->cn()->get_dt_consumo_convenio();
			$form->set_datos($datos);
		}
	}

	function evt__frm_ayuda_mutual__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_consumo_convenio())
		{
			$this->cn()->set_dt_consumo_convenio($datos);
		} else {
			$this->cn()->agregar_dt_consumo_convenio($datos);
		}
	}

}
?>