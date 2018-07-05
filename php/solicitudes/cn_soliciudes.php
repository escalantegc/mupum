<?php
class cn_soliciudes extends mupum_cn
{
	function cargar_dr_solicitudes()	
	{
		if(!$this->dep('dr_solicitudes')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_solicitudes')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_solicitudes')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	

	function cargar_dr_usuario()	
	{
		if(!$this->dep('dr_usuario')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_usuario')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_usuario')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	
	function guardar_dr_solicitudes()
	{
		$this->dep('dr_solicitudes')->sincronizar();
	}

	function resetear_dr_solicitudes()
	{
		$this->dep('dr_solicitudes')->resetear();
	}

	function guardar_dr_reserva()
	{
		$this->dep('dr_reserva')->sincronizar();
	}

	function resetear_dr_reserva()
	{
		$this->dep('dr_reserva')->resetear();
	}
	function guardar_dr_usuario()
	{
		$this->dep('dr_usuario')->sincronizar();
	}

	function resetear_dr_usuario()
	{
		$this->dep('dr_usuario')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-PERSONA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_persona($seleccion)
	{
		if(!$this->dep('dr_solicitudes')->tabla('dt_persona')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_solicitudes')->tabla('dt_persona')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_solicitudes')->tabla('dt_persona')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_persona($seleccion)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_persona')->get_id_fila_condicion($seleccion);
		$this->dep('dr_solicitudes')->tabla('dt_persona')->set_cursor($id[0]);
	}	

	function existe_dt_persona($condicion)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_persona')->existe_fila_condicion($condicion);
		if ($id==1)
		{
			return 'existe';
		} else {
			return 'noexiste';
		}
	}
	
	function hay_cursor_dt_persona()
	{
		return $this->dep('dr_solicitudes')->tabla('dt_persona')->hay_cursor();
	}

	function resetear_cursor_dt_persona()
	{
		$this->dep('dr_solicitudes')->tabla('dt_persona')->resetear_cursor();
	}

	function get_dt_persona()
	{
		return $this->dep('dr_solicitudes')->tabla('dt_persona')->get();
	}

	function set_dt_persona($datos)
	{
		$this->dep('dr_solicitudes')->tabla('dt_persona')->set($datos);
	}

	function agregar_dt_persona($datos)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_persona')->nueva_fila($datos);
		$this->dep('dr_solicitudes')->tabla('dt_persona')->set_cursor($id);
	}	

	function eliminar_dt_persona($seleccion)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_persona')->get_id_fila_condicion($seleccion);
		$this->dep('dr_solicitudes')->tabla('dt_persona')->eliminar_fila($id[0]);
	}
	

	//-----------------------------------------------------------------------------------
	//---- DT-AFILACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_afiliacion($seleccion)
	{
		if(!$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}

	function guardar_dt_afiliacion()
	{
		$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->sincronizar();
	}

	function set_cursor_dt_afiliacion($seleccion)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_afiliacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_afiliacion()
	{
		return $this->dep('dr_solicitudes')->tabla('dt_afiliacion')->hay_cursor();
	}

	function resetear_cursor_dt_afiliacion()
	{
		$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->resetear_cursor();
	}

	function get_dt_afiliacion()
	{
		return $this->dep('dr_solicitudes')->tabla('dt_afiliacion')->get();
	}

	function set_dt_afiliacion($datos)
	{
		$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->set($datos);
	}

	function agregar_dt_afiliacion($datos)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_afiliacion')->nueva_fila($datos);
		$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->set_cursor($id);
	}	

	function eliminar_dt_afiliacion($seleccion)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_afiliacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_solicitudes')->tabla('dt_afiliacion')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- Dr-RESERVA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_reserva($seleccion)
	{
		if(!$this->dep('dr_reserva')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_reserva')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_reserva')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	//-----------------------------------------------------------------------------------
	//---- DT-RESERVA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_reserva($seleccion)
	{
		if(!$this->dep('dr_reserva')->tabla('dt_reserva')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_reserva')->tabla('dt_reserva')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_reserva')->tabla('dt_reserva')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_reserva($seleccion)
	{
		$id = $this->dep('dr_reserva')->tabla('dt_reserva')->get_id_fila_condicion($seleccion);
		$this->dep('dr_reserva')->tabla('dt_reserva')->set_cursor($id[0]);
	}

	function hay_cursor_dt_reserva()
	{
		return $this->dep('dr_reserva')->tabla('dt_reserva')->hay_cursor();
	}

	function resetear_cursor_dt_reserva()
	{
		$this->dep('dr_reserva')->tabla('dt_reserva')->resetear_cursor();
	}

	function get_dt_reserva()
	{
		return $this->dep('dr_reserva')->tabla('dt_reserva')->get();
	}

	function set_dt_reserva($datos)
	{
		$this->dep('dr_reserva')->tabla('dt_reserva')->set($datos);
	}

	function agregar_dt_reserva($datos)
	{
		$id = $this->dep('dr_reserva')->tabla('dt_reserva')->nueva_fila($datos);
		$this->dep('dr_reserva')->tabla('dt_reserva')->set_cursor($id);
	}	

	function eliminar_dt_reserva($seleccion)
	{
		$id = $this->dep('dr_reserva')->tabla('dt_reserva')->get_id_fila_condicion($seleccion);
		$this->dep('dr_reserva')->tabla('dt_reserva')->eliminar_fila($id[0]);
	}
	//-----------------------------------------------------------------------------------
	//---- DT-DETALLE PAGO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function procesar_dt_detalle_pago($datos)
	{
		$this->dep('dr_reserva')->tabla('dt_detalle_pago')->procesar_filas($datos);
	}

	function get_dt_detalle_pago()
	{
		return $this->dep('dr_reserva')->tabla('dt_detalle_pago')->get_filas();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-USUARIO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_usuario($seleccion)
	{
		if(!$this->dep('dr_usuario')->tabla('dt_usuario')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_usuario')->tabla('dt_usuario')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_usuario')->tabla('dt_usuario')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}

	function guardar_dt_usuario()
	{
		$this->dep('dr_usuario')->tabla('dt_usuario')->sincronizar();
	}	

	function resetear_dt_usuario()
	{
		$this->dep('dr_usuario')->tabla('dt_usuario')->resetear();
	}

	function set_cursor_dt_usuario($seleccion)
	{
		$id = $this->dep('dr_usuario')->tabla('dt_usuario')->get_id_fila_condicion($seleccion);
		$this->dep('dr_usuario')->tabla('dt_usuario')->set_cursor($id[0]);
	}

	function hay_cursor_dt_usuario()
	{
		return $this->dep('dr_usuario')->tabla('dt_usuario')->hay_cursor();
	}

	function resetear_cursor_dt_usuario()
	{
		$this->dep('dr_usuario')->tabla('dt_usuario')->resetear_cursor();
	}

	function get_dt_usuario()
	{
		return $this->dep('dr_usuario')->tabla('dt_usuario')->get();
	}

	function set_dt_usuario($datos)
	{
		$this->dep('dr_usuario')->tabla('dt_usuario')->set($datos);
	}

	function agregar_dt_usuario($datos)
	{
		$id = $this->dep('dr_usuario')->tabla('dt_usuario')->nueva_fila($datos);
		$this->dep('dr_usuario')->tabla('dt_usuario')->set_cursor($id);
	}	

	function eliminar_dt_usuario($seleccion)
	{
		$id = $this->dep('dr_usuario')->tabla('dt_usuario')->get_id_fila_condicion($seleccion);
		$this->dep('dr_usuario')->tabla('dt_usuario')->eliminar_fila($id[0]);
	}

	function existe_dt_usuario($condicion)
	{
		$id = $this->dep('dr_usuario')->tabla('dt_usuario')->existe_fila_condicion($condicion);
		if ($id==1)
		{
			return 'existe';
		} else {
			return 'noexiste';
		}
	}

	//-----------------------------------------------------------------------------------
	//---- DT-USUARIO-PROYECTO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_usuario_proyecto($seleccion)
	{
		if(!$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}

	function guardar_dt_usuario_proyecto()
	{
		$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->sincronizar();
	}	

	function resetear_dt_usuario_proyecto()
	{
		$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->resetear();
	}

	function set_cursor_dt_usuario_proyecto($seleccion)
	{
		$id = $this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->get_id_fila_condicion($seleccion);
		$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->set_cursor($id[0]);
	}

	function hay_cursor_dt_usuario_proyecto()
	{
		return $this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->hay_cursor();
	}

	function resetear_cursor_dt_usuario_proyecto()
	{
		$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->resetear_cursor();
	}

	function get_dt_usuario_proyecto()
	{
		return $this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->get_filas();
	}

	function procesar_dt_usuario_proyecto($datos)
	{
		$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->procesar_filas($datos);
	}

	function set_dt_usuario_proyecto($datos)
	{
		$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->set($datos);
	}

	function agregar_dt_usuario_proyecto($datos)
	{
		$id = $this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->nueva_fila($datos);
		$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->set_cursor($id);
	}	

	function eliminar_dt_usuario_proyecto($seleccion)
	{
		$id = $this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->get_id_fila_condicion($seleccion);
		$this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->eliminar_fila($id[0]);
	}

	function existe_dt_usuario_proyecto($condicion)
	{
		$id = $this->dep('dr_usuario')->tabla('dt_usuario_proyecto')->existe_fila_condicion($condicion);
		if ($id==1)
		{
			return 'existe';
		} else {
			return 'noexiste';
		}
	}
}

?>