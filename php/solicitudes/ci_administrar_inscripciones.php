<?php
class ci_administrar_inscripciones extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_pileta();
			
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'inscripcion_pileta_idtemporada_pileta_idafiliacion_idx'))
			{
				toba::notificacion()->agregar("Su grupo familiar ya se encuentra inscripto, si desea agregar mas personas al grupo debe editar la inscripcion..",'info');
	
			} 
			
		}
		$this->cn()->resetear_dr_pileta();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_pileta();
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
			$datos = dao::get_listado_inscripcion_pileta($this->s__where);
		}else{
			$datos = dao::get_listado_inscripcion_pileta();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_pileta($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->eliminar_dt_inscripcion_pileta($seleccion);
		$this->cn()->guardar_dr_pileta();
		try{
			

			
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("No puede borrar al inscripcion del grupo familiar.",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_pileta();
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

	function conf__frm(ei_frm_pileta $form)
	{
		if ($this->cn()->hay_cursor_dt_inscripcion_pileta())
		{
			$datos = $this->cn()->get_dt_inscripcion_pileta();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{	
		if ($this->cn()->hay_cursor_dt_inscripcion_pileta())
		{
			$this->cn()->set_dt_inscripcion_pileta($datos);
		} else {
			$datos['fecha'] = date('Y-m-j');
			$this->cn()->agregar_dt_inscripcion_pileta($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_detalle_pago_pileta ---------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_detalle_pago_pileta(ei_frm_detalle_pago_pileta $form_ml)
	{

		return $this->cn()->get_dt_detalle_pago_inscripcion_pileta();
	}

	function evt__frm_ml_detalle_pago_pileta__modificacion($datos)
	{
		$inscripcion = $this->cn()->get_dt_inscripcion_pileta();
		$detalles = array();
		
		foreach ($datos as $dato) 
		{
			if (($dato['apex_ei_analisis_fila'] == 'A') or ($dato['apex_ei_analisis_fila'] == 'M'))
			{
				if(isset($dato['idforma_pago']))
				{
					$periodo = dao::sacar_periodo_fecha($dato['fecha']);
					$fp = dao::get_forma_pago_idforma_pago($dato['idforma_pago']);
					if ($fp[0]['planilla']==1)
					{
						$dato['periodo'] = $periodo;	
						$dato['planilla'] = 'si';	
						$detalles[] = $dato;	
					} else {
						$dato['periodo'] = $periodo;	
						$dato['planilla'] = 'no';	
						$detalles[] = $dato;	
					}
				}	
			} else {
				$detalles[] = $dato;
			}
	
		}

		for ($i=0;$i<count($detalles);$i++)
		{
		    for ($j = $i+1; $j<count($detalles);$j++)
		    {
	    		if ($detalles[$i]['periodo'] == $detalles[$j]['periodo'])
				{
					$detalles[$i]['monto'] = $detalles[$i]['monto'] + $detalles[$j]['monto'];
					$detalles[$j]['monto'] = 0;
				}	
		    }
		}
		$hoy = date("m/Y");  
		$bandera = 'no';  
		foreach ($detalles as $detalle) 
		{
			if ($detalle['periodo'] == $hoy)
			{
				if ($detalle['monto'] > 0)
				{
					if ($detalle['planilla']=='si')
					{
						$total_por_consumir = $detalle['monto'];
						///--$total_consumido = dao::get_total_consumido_en_bono_por_convenio_por_socio($datos['idafiliacion'],$datos['idconvenio']);
						//--$maximo_por_convenio = dao::get_monto_maximo_mensual_convenio($datos['idconvenio']); 
						
					
						$estado_situacion = dao::get_total_estado_situacion($detalle['periodo'],$inscripcion['idafiliacion']);
						$configuracion = dao::get_configuracion();
						$limite_socio = $configuracion['limite_por_socio'];


						//--$total = $total_por_consumir + $total_consumido;

						$estado_total = $estado_situacion + $total_por_consumir;  
						if ($estado_total < $limite_socio)
						{
							$bandera = 'si';
							
						} else {

							toba::notificacion()->agregar("El afiliado lleva consumido en este periodo de : $".$estado_situacion. ", mas el valor del detalle de pago de pileta : $".round($total_por_consumir,2). " .Supera el limite maximo permitido por periodo por socio en la mutual de : $" .$limite_socio ,'info');
						}	
					} else {
						$bandera = 'si';
					}
				} 
			} else {
				if ($detalle['apex_ei_analisis_fila'] == 'B')
				{
					$bandera = 'si';
				}
			}
			

		}

		if ($bandera == 'si')
		{
			$this->cn()->procesar_dt_detalle_pago_inscripcion_pileta($datos);
		}
			

			
		
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_grupo_familiar --------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_grupo_familiar(eI_frm_ml_grupo_familiar $form_ml)
	{
		return $this->cn()->get_dt_detalle_inscripcion_pileta();
	}

	function evt__frm_ml_grupo_familiar__modificacion($datos)
	{
		$this->cn()->procesar_dt_detalle_inscripcion_pileta($datos);
	}

}

?>