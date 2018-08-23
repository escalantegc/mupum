<?php
class cn_consumos extends mupum_cn
{

	//-----------------------------------------------------------------------------------
	//---- DR-CONSUMO-BONO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function cargar_dr_consumo_bono($seleccion)	
	{
		if(!$this->dep('dr_consumo_bono')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumo_bono')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumo_bono')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_consumo_bono()
	{
		$this->dep('dr_consumo_bono')->sincronizar();
	}

	function resetear_dr_consumo_bono()
	{
		$this->dep('dr_consumo_bono')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-CONSUMO-BONO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_consumo_bono($seleccion)
	{
		if(!$this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_consumo_bono($seleccion)
	{
		$id = $this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->set_cursor($id[0]);
	}

	function hay_cursor_dt_consumo_bono()
	{
		return $this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->hay_cursor();
	}

	function resetear_cursor_dt_consumo_bono()
	{
		$this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->resetear_cursor();
	}

	function get_dt_consumo_bono()
	{
		return $this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->get();
		
	}	

	function get_dt_consumo_bono_sin_blob()
	{
		return $this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->get();

	}

	function set_dt_consumo_bono($datos)
	{
		$this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->set($datos);

	}

	function agregar_dt_consumo_bono($datos)
	{
		$id = $this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->nueva_fila($datos);
		$this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->set_cursor($id);

	}

	function eliminar_dt_consumo_bono($seleccion)
	{
		$id = $this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumo_bono')->tabla('dt_consumo_bono')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-TALONARIO-NROS-BONO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function cargar_dt_talonario_nros_bonos($seleccion)
	{
		if(!$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}

	function get_dt_talonario_nros_bonos()
	{
		return $this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->get_filas();
	}	

	function procesar_dt_talonario_nros_bono($datos)
	{
		$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->procesar_filas($datos);
	}

	function set_cursor_dt_talonario_nros_bono($seleccion)
	{
		$id = $this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->set_cursor($id[0]);
	}

	function hay_cursor_dt_talonario_nros_bono()
	{
		return $this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->hay_cursor();
	}

	function resetear_cursor_dt_talonario_nros_bono()
	{
		$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->resetear_cursor();
	}
	function resetear_dt_talonario_nros_bono()
	{
		$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->resetear();
	}

	function get_dt_talonario_nros_bono()
	{
		return $this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->get();
		
	}	

	function get_dt_talonario_nros_bono_sin_blob()
	{
		return $this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->get();

	}

	function set_dt_talonario_nros_bono($datos)
	{
		$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->set($datos);

	}

	function agregar_dt_talonario_nros_bono($datos)
	{
		$id = $this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->nueva_fila($datos);
		$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->set_cursor($id);

	}

	function eliminar_dt_talonario_nros_bono($seleccion)
	{
		$id = $this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumo_bono')->tabla('dt_talonario_nros_bono')->eliminar_fila($id[0]);
	}	

		//-----------------------------------------------------------------------------------
	//---- DR-CONSUMO-BONO-PROPIO-----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function cargar_dr_consumo_bono_propio($seleccion)	
	{
		if(!$this->dep('dr_consumo_bono_propio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumo_bono_propio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumo_bono_propio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_consumo_bono_propio()
	{
		$this->dep('dr_consumo_bono_propio')->sincronizar();
	}

	function resetear_dr_consumo_bono_propio()
	{
		$this->dep('dr_consumo_bono_propio')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-CONSUMO-BONO-PROPIO-----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function set_cursor_dt_consumo_bono_propio($seleccion)
	{
		$id = $this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->set_cursor($id[0]);
	}

	function hay_cursor_dt_consumo_bono_propio()
	{
		return $this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->hay_cursor();
	}

	function resetear_cursor_dt_consumo_bono_propio()
	{
		$this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->resetear_cursor();
	}

	function get_dt_consumo_bono_propio()
	{
		return $this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->get();
		
	}	

	function get_dt_consumo_bono_sin_blob_propio()
	{
		return $this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->get();

	}

	function set_dt_consumo_bono_propio($datos)
	{
		$this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->set($datos);

	}

	function agregar_dt_consumo_bono_propio($datos)
	{
		$id = $this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->nueva_fila($datos);
		$this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->set_cursor($id);

	}

	function eliminar_dt_consumo_bono_propio($seleccion)
	{
		$id = $this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumo_bono_propio')->tabla('dt_consumo_bono')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-TALONARIO-NROS-BONO-PROPIO-----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function get_dt_talonario_nros_bonos_propio()
	{
		return $this->dep('dr_consumo_bono_propio')->tabla('dt_talonario_nros_bono')->get_filas();
	}	

	function get_dt_talonario_nros_bonos_propio_filtrado($filtro)
	{
		return $this->dep('dr_consumo_bono_propio')->tabla('dt_talonario_nros_bono')->get_filas($filtro);
	}	

	function procesar_dt_talonario_nros_bono_propio($datos)
	{
		$this->dep('dr_consumo_bono_propio')->tabla('dt_talonario_nros_bono')->procesar_filas($datos);
	}

	function set_dt_talonario_nros_bono_propio($datos)
	{
		$this->dep('dr_consumo_bono_propio')->tabla('dt_talonario_nros_bono')->set($datos);

	}	
	function set_cursor_dt_talonario_nros_bono_propio($seleccion)
	{
		$this->dep('dr_consumo_bono_propio')->tabla('dt_talonario_nros_bono')->set_cursor($seleccion);

	}
	
	//-----------------------------------------------------------------------------------
	//---- DT-DETALLE-PAGO-CONSUMO-BONO-----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function get_dt_detalle_pago_propio()
	{
		return $this->dep('dr_consumo_bono_propio')->tabla('dt_detalle_pago')->get_filas();
	}	

	function procesar_dt_detalle_pago_bono_propio($datos)
	{
		$this->dep('dr_consumo_bono_propio')->tabla('dt_detalle_pago')->procesar_filas($datos);
	}



	//-----------------------------------------------------------------------------------
	//---- DR-CONSUMO-TICKET -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_consumo_ticket()	
	{
		if(!$this->dep('dr_consumo_ticket')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumo_ticket')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumo_ticket')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_consumo_ticket()
	{
		$this->dep('dr_consumo_ticket')->sincronizar();
	}

	function resetear_dr_consumo_ticket()
	{
		$this->dep('dr_consumo_ticket')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DR-CONSUMO-CONVENIO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_consumo_convenio()	
	{
		if(!$this->dep('dr_consumo_convenio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumo_convenio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumo_convenio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_consumo_convenio()
	{
		$this->dep('dr_consumo_convenio')->sincronizar();
	}

	function resetear_dr_consumo_convenio()
	{
		$this->dep('dr_consumo_convenio')->resetear();
	}
	//-----------------------------------------------------------------------------------
	//---- DT-CONSUMO-CONVENIO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_consumo_convenio($seleccion)
	{
		if(!$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_consumo_convenio($seleccion)
	{
		$id = $this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->set_cursor($id[0]);
	}

	function hay_cursor_dt_consumo_convenio()
	{
		return $this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->hay_cursor();
	}

	function resetear_cursor_dt_consumo_convenio()
	{
		$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->resetear_cursor();
	}

	function get_dt_consumo_convenio()
	{
		return $this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->get();
		
	}	

	function get_dt_consumo_convenio_sin_blob()
	{
		return $this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->get();

	}

	function set_dt_consumo_convenio($datos)
	{
		$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->set($datos);

	}

	function agregar_dt_consumo_convenio($datos)
	{
		$id = $this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->nueva_fila($datos);
		$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->set_cursor($id);

	}

	function eliminar_dt_consumo_convenio($seleccion)
	{
		$id = $this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->eliminar_fila($id[0]);
	}	

	function procesar_dt_consumo_convenio($datos)
	{
	 	$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio')->procesar_filas($datos);	
	}

	//-----------------------------------------------------------------------------------
	//---- DT-CONSUMO-CONVENIO-COUTAS-----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function get_dt_consumo_convenio_cuotas()
	{
		return $this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio_cuotas')->get_filas();
	}	
	function get_dt_consumo_convenio_cuotas_filtro($filtro)
	{
		return $this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio_cuotas')->get_filas($filtro);
	}	

	function procesar_dt_consumo_convenio_cuotas($datos)
	{
		$this->dep('dr_consumo_convenio')->tabla('dt_consumo_convenio_cuotas')->procesar_filas($datos);
	}
	//-----------------------------------------------------------------------------------
	//---- DT-DETALLE-PAGO-CONSUMO-CONVENIO-----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function get_dt_detalle_pago_consumo_convenio()
	{
		return $this->dep('dr_consumo_convenio')->tabla('dt_detalle_pago_consumo_convenio')->get_filas();
	}	

	function procesar_dt_detalle_pago_consumo_convenio($datos)
	{
		$this->dep('dr_consumo_convenio')->tabla('dt_detalle_pago_consumo_convenio')->procesar_filas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-DETALLE-CONSUMO-TICKET-----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	
	function get_dt_detalle_consumo_ticket()
	{
		return $this->dep('dr_consumo_convenio')->tabla('dt_detalle_consumo_ticket')->get_filas();
	}	

	function procesar_dt_detalle_consumo_ticket($datos)
	{
		$this->dep('dr_consumo_convenio')->tabla('dt_detalle_consumo_ticket')->procesar_filas($datos);
	}

}

?>