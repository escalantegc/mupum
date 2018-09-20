<?php
class ci_administracion_colonos extends mupum_ci
{
	protected $s__seleccion_adm_plan;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
				$this->cn()->guardar_dr_administrar_colonia();

				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La solicitud de subsidio esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_descripcion'))
			{
				toba::notificacion()->agregar("La solicitud de subsidio ya esta registrado.",'info');
				
			} 
			
		}
		$this->cn()->resetear_dr_administrar_colonia();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_administrar_colonia();
		$this->set_pantalla('pant_inicial');
	}
	function evt__volver()
	{
		$this->cn()->resetear_dr_administrar_colonia();
		$this->set_pantalla('pant_inicial');	
	}

	function evt__volver_inscripciones()
	{
		$this->cn()->resetear_dt_inscripcion_colono_plan_pago();
		$this->set_pantalla('pant_plan_colono');
	}
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

	function evt__cuadro__generar_plan($seleccion)
	{	
		$this->cn()->cargar_dt_inscripcion_colono1($seleccion);
		//$this->cn()->set_cursor_dt_afiliacion_colonia($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dt_inscripcion_colono1($seleccion);
		$this->cn()->eliminar_dt_inscripcion_colono1($seleccion);
		try{
			$this->cn()->guardar_dr_administrar_colonia();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("No puede borrar al inscripcion del colono, la misma tiene plan de pago.",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');
	}
	//----------------------------------------------------------------------------------
	//---- cuadro_colono_plan -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_colono_plan(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_colonos_del_afiliado_con_plan($this->s__where);
		}else{
			$datos = dao::get_colonos_del_afiliado_con_plan();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_colono_plan__administrar_plan($seleccion)
	{
			$this->s__seleccion_adm_plan = $seleccion;
		$this->set_pantalla('pant_plan_colono');
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
		$filtro['cantidad_cuotas'] = 0;
		return $this->cn()->get_dt_inscripcion_colonos_filtro($filtro);
	}

	function evt__frm_ml_colonos__modificacion($datos)
	{
		$this->cn()->procesar_dt_inscripcion_colonos($datos);
	}




	//-----------------------------------------------------------------------------------
	//---- cuadro_plan ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_plan(mupum_ei_cuadro $cuadro)
	{

		$where = 'afiliacion.idafiliacion =' .$this->s__seleccion_adm_plan['idafiliacion'];
		$datos = dao::get_listado_inscripcion_colono_sin_baja($where);
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_plan__seleccion($seleccion)
	{
		$this->cn()->cargar_dt_inscripcion_colono_plan_pago($seleccion);
		//$this->cn()->set_cursor_dt_afiliacion_colonia($seleccion);

		$tipo_socio = dao::get_listado_inscripcion_colono_sin_baja('inscripcion_colono.idinscripcion_colono =' .$seleccion['idinscripcion_colono']);
		if ($tipo_socio[0]['titular']==1)
		{
			$this->set_pantalla('pant_edicion_plan_colono_titular');
		} else {
			$this->set_pantalla('pant_edicion_plan_colono');
		}
		
	}


	function evt__cuadro_plan__borrar($seleccion)
	{
		$this->cn()->cargar_dt_inscripcion_colono1($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_colono1($seleccion);
		$datos['baja'] = 1;
		$this->cn()->set_dt_inscripcion_colono1($datos);
		try{
			$this->cn()->guardar_dr_administrar_colonia();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("No puede borrar al inscripcion del colono, la misma tiene plan de pago.",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');

	}
	function evt__cuadro_plan__alta($seleccion)
	{
		$this->cn()->cargar_dt_inscripcion_colono1($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_colono1($seleccion);
		$datos['baja'] = 0;
		$this->cn()->set_dt_inscripcion_colono1($datos);
		try{
			$this->cn()->guardar_dr_administrar_colonia();
				toba::notificacion()->agregar("Los datos se han recuperado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("No puede borrar al inscripcion del colono, la misma tiene plan de pago.",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_plan ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_plan(mupum_ei_formulario_ml $form_ml)
	{
		return $this->cn()->get_dt_inscripcion_colono_plan_pago();
	}

	function evt__frm_ml_plan__modificacion($datos)
	{
		$this->cn()->procesar_dt_inscripcion_colono_plan_pago($datos);

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
	//---- frm_ml_plan_externo ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_plan_externo(ei_frm_ml_plan_externo $form_ml)
	{
		return $this->cn()->get_dt_inscripcion_colono_plan_pago();
	}

	function evt__frm_ml_plan_externo__modificacion($datos)
	{
		$this->cn()->procesar_dt_inscripcion_colono_plan_pago($datos);
	}

}
?>