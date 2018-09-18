<?php
class ci_solicitar_ayuda_economica_mutual extends mupum_ci
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
			$datos = dao::get_listado_ayuda_economica_mutual($this->s__where);
		}else{
			$datos = dao::get_listado_ayuda_economica_mutual();
		}
		
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_consumo_convenio($seleccion);
		$this->cn()->set_cursor_dt_consumo_convenio($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_consumo_convenio($seleccion);
		$this->cn()->set_cursor_dt_consumo_convenio($seleccion);
		$datos = $this->cn()->get_dt_consumo_convenio_cuotas();
		$borrar = 'si';
		foreach ($datos as $dato) 
		{
			if($dato['cuota_pagada'] == 1)
			{
				$borrar = 'no';
				break;
			}
		}

		if ($borrar =='si')
		{	
			$this->cn()->eliminar_dt_consumo_convenio($seleccion);
			try{
				$this->cn()->guardar_dr_consumo_convenio();
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
				
				} catch( toba_error_db $error){
					$sql_state= $error->get_sqlstate();
					
					toba::notificacion()->agregar($mensaje_log,'error');
			}
		} else {
			toba::notificacion()->agregar("No puede borrar la ayuda economica, la misma tiene cuotas sin saldar",'info');
		}
		$this->cn()->resetear_dr_consumo_convenio();
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro_historico -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_historico(mupum_ei_cuadro $cuadro)
	{
		$this->dep('cuadro_historico')->colapsar();
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_ayuda_economica_mutual_historico($this->s__where);
		}else{
			$datos = dao::get_listado_ayuda_economica_mutual_historico();
		}
		
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_historico__seleccion($seleccion)
	{
				$this->cn()->cargar_dr_consumo_convenio($seleccion);
		$this->cn()->set_cursor_dt_consumo_convenio($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro_historico__ver($seleccion)
	{
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
	//---- frm_ayuda_mutual -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ayuda_mutual(ei_frm_ayuda_economica $form)
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

	function evt__frm_ayuda_mutual__modificacion($datos)
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
		$filtro['cuota_pagada'] = 0;
		$datos = $this->cn()->get_dt_consumo_convenio_cuotas_filtro($filtro);
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_detalle_ayuda__modificacion($datos)
	{
		//ei_arbol($datos);
		$this->cn()->procesar_dt_consumo_convenio_cuotas($datos);
	}

	function ajax__es_planilla($idfp, toba_ajax_respuesta $respuesta)
	{
		$fp = dao::get_listado_forma_pago('idforma_pago = '.$idfp[1]);
		
		$forma_pago['planilla'] = 'no';
		$forma_pago['fila'] = $idfp[2];
		if ($fp[0]['planilla']==1)
		{
			$forma_pago['planilla'] = 'si';
		}
		$respuesta->set($forma_pago);	
	}

	

	//-----------------------------------------------------------------------------------
	//---- cuadro_cuotas_pagas ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_cuotas_pagas(mupum_ei_cuadro $cuadro)
	{
		if ($this->cn()->hay_cursor_dt_consumo_convenio())
		{
			$datos = $this->cn()->get_dt_consumo_convenio();
			$cuotas = dao::get_cuotas_pagas_consumo_convenio($datos['idconsumo_convenio']);
			$cuadro->set_datos($cuotas);
		}
	}





}
?>