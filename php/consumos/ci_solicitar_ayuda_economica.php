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
			
			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_consumo_convenio'))
			{
				toba::notificacion()->agregar("La ayuda economica ya esta registrada.",'info');
				
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
		$cuotas_faltantes = dao::get_cuotas_faltantes_ayuda();
		$pendientes = dao::get_ayuda_economicas_pendientes();
		
		if ($pendientes > 0)
		{
			toba::notificacion()->agregar("Usted tiene una ayuda economica pendiente de aprobacion. Por favor comuniquese con el personal de la mutual." ,'info');

		} else {
			if ( $cuotas_faltantes <= $minimo)
			{
				$diahoy = date("d"); 
				if ((int)$diahoy > (int) $conf['fecha_limite_pedido_convenio'])
				{
					toba::notificacion()->agregar("Puede solicitar ayuda economica solamente hasta el: ".$conf['fecha_limite_pedido_convenio']. " del mes." ,'info');
				} else {
					$this->set_pantalla('pant_edicion');	
				}
			} else {
				toba::notificacion()->agregar("Usted tiene una ayuda economica vigente y debe ".$cuotas_faltantes. " cuotas. Solo podra solicitar otra ayuda cuando deba como minimo ".$minimo. " cuotas." ,'info');

			}
		}
		
	
		
	

	}	

	function evt__nuevo_libre()
	{
		$this->set_pantalla('pant_edicion');	
	}
	function evt__volver()
	{
		$this->cn()->resetear_dr_consumo_convenio();
		$this->set_pantalla('pant_inicial');
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
				toba::notificacion()->agregar("No puede borrar la ayuda economica, la misma tiene cuotas pagadas",'error');
		}
		$this->cn()->resetear_dr_consumo_convenio();
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
			$form->set_datos($datos);
		}
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





}
?>