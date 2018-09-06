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

	function cargar_dr_reempadronamiento ()	
	{
		if(!$this->dep('dr_reempadronamiento')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_reempadronamiento')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_reempadronamiento')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
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

	function guardar_dr_reempadronamiento()
	{
		$this->dep('dr_reempadronamiento')->sincronizar();
	}

	function resetear_dr_reempadronamiento()
	{
		$this->dep('dr_reempadronamiento')->resetear();
	}
	function guardar_dr_bolsita()
	{
		$this->dep('dr_bolsita')->sincronizar();
	}

	function resetear_dr_bolsita()
	{
		$this->dep('dr_bolsita')->resetear();
	}	

	function guardar_dr_subsidio()
	{
		$this->dep('dr_subsidio')->sincronizar();
	}

	function resetear_dr_subsidio()
	{
		$this->dep('dr_subsidio')->resetear();
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
	//---- DT-DETALLE MODIFICACION MONTO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function procesar_detalle_modificacion_monto($datos)
	{
		$this->dep('dr_reserva')->tabla('dt_detalle_modificacion_monto')->procesar_filas($datos);
	}

	function get_detalle_modificacion_monto()
	{
		return $this->dep('dr_reserva')->tabla('dt_detalle_modificacion_monto')->get_filas();
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


	//-----------------------------------------------------------------------------------
	//---- DT-REEMPADRONAMIENTO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_reempadronamiento($seleccion)
	{
		if(!$this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_reempadronamiento($seleccion)
	{
		$id = $this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->get_id_fila_condicion($seleccion);
		$this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->set_cursor($id[0]);
	}

	function hay_cursor_dt_reempadronamiento()
	{
		return $this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->hay_cursor();
	}

	function resetear_cursor_dt_reempadronamiento()
	{
		$this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->resetear_cursor();
	}

	function get_dt_reempadronamiento()
	{
		return $this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->get();
	}

	function set_dt_reempadronamiento($datos)
	{
		$this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->set($datos);
	}

	function agregar_dt_reempadronamiento($datos)
	{
		$id = $this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->nueva_fila($datos);
		$this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->set_cursor($id);
	}	

	function eliminar_dt_reempadronamiento($seleccion)
	{
		$id = $this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->get_id_fila_condicion($seleccion);
		$this->dep('dr_reempadronamiento')->tabla('dt_reempadronamiento')->eliminar_fila($id[0]);
	}
	//-----------------------------------------------------------------------------------
	//---- DT-SOLICITUD-REEMPADRONAMIENTO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_solicitud_reempadronamiento($seleccion)
	{
		if(!$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	
	function resetear_dt_solicitud_reempadronamiento()
	{
		
		$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->resetear();					// lee de la BD fisica y carga al datos relacion
			
	}
	function set_cursor_dt_solicitud_reempadronamiento($seleccion)
	{
		$id = $this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->get_id_fila_condicion($seleccion);

		$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->set_cursor($id[0]);
	}

	function hay_cursor_dt_solicitud_reempadronamiento()
	{
		return $this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->hay_cursor();
	}

	function resetear_cursor_dt_solicitud_reempadronamiento()
	{
		$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->resetear_cursor();
	}

	function get_dt_solicitud_reempadronamiento()
	{
		return $this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->get();
	}

	function set_dt_solicitud_reempadronamiento($datos)
	{
		$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->set($datos);
	}

	function agregar_dt_solicitud_reempadronamiento($datos)
	{
		$id = $this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->nueva_fila($datos);
		$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->set_cursor($id);
	}	

	function eliminar_dt_solicitud_reempadronamiento($seleccion)
	{
		$id = $this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->get_id_fila_condicion($seleccion);
		$this->dep('dr_reempadronamiento')->tabla('dt_solicitud_reempadronamiento')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-SOLICITUD-SUBSIDIO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_solicitud_bolsita($seleccion)
	{
		if(!$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	
	function resetear_dt_solicitud_bolsita()
	{
		
		$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->resetear();					// lee de la BD fisica y carga al datos relacion
			
	}
	function set_cursor_dt_solicitud_bolsita($seleccion)
	{
		$id = $this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->get_id_fila_condicion($seleccion);

		$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->set_cursor($id[0]);
	}

	function hay_cursor_dt_solicitud_bolsita()
	{
		return $this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->hay_cursor();
	}

	function resetear_cursor_dt_solicitud_bolsita()
	{
		$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->resetear_cursor();
	}

	function get_dt_solicitud_bolsita()
	{
		return $this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->get();
	}

	function set_dt_solicitud_bolsita($datos)
	{
		$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->set($datos);
	}

	function agregar_dt_solicitud_bolsita($datos)
	{
		$id = $this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->nueva_fila($datos);
		$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->set_cursor($id);
	}	

	function eliminar_dt_solicitud_bolsita($seleccion)
	{
		$id = $this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->get_id_fila_condicion($seleccion);
		$this->dep('dr_bolsita')->tabla('dt_solicitud_bolsita')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-SOLICITUD-BOLSITA-ESCOLAR -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_solicitud_subsidio($seleccion)
	{
		if(!$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	
	function resetear_dt_solicitud_subsidio()
	{
		
		$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->resetear();					// lee de la BD fisica y carga al datos relacion
			
	}
	function set_cursor_dt_solicitud_subsidio($seleccion)
	{
		$id = $this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->get_id_fila_condicion($seleccion);

		$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->set_cursor($id[0]);
	}

	function hay_cursor_dt_solicitud_subsidio()
	{
		return $this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->hay_cursor();
	}

	function resetear_cursor_dt_solicitud_subsidio()
	{
		$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->resetear_cursor();
	}

	function get_dt_solicitud_subsidio()
	{
		return $this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->get();
	}

	function set_dt_solicitud_subsidio($datos)
	{
		$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->set($datos);
	}

	function agregar_dt_solicitud_subsidio($datos)
	{
		$id = $this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->nueva_fila($datos);
		$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->set_cursor($id);
	}	

	function eliminar_dt_solicitud_subsidio($seleccion)
	{
		$id = $this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_subsidio')->tabla('dt_solicitud_subsidio')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DR-BONO COLABORACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_bono_colaboracion ()	
	{
		if(!$this->dep('dr_bono_colaboracion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_bono_colaboracion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_bono_colaboracion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	
	function guardar_dr_bono_colaboracion()
	{
		$this->dep('dr_bono_colaboracion')->sincronizar();
	}

	function resetear_dr_bono_colaboracion()
	{
		$this->dep('dr_bono_colaboracion')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-TALONARIO-BONO-COLABORACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_talonario_bono_colaboracion($seleccion)
	{
		if(!$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	
	function resetear_dt_talonario_bono_colaboracion()
	{
		
		$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->resetear();					// lee de la BD fisica y carga al datos relacion
			
	}
	function set_cursor_dt_talonario_bono_colaboracion($seleccion)
	{
		$id = $this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->get_id_fila_condicion($seleccion);

		$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_talonario_bono_colaboracion()
	{
		return $this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->hay_cursor();
	}

	function resetear_cursor_dt_talonario_bono_colaboracion()
	{
		$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->resetear_cursor();
	}

	function get_dt_talonario_bono_colaboracion()
	{
		return $this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->get();
	}

	function set_dt_talonario_bono_colaboracion($datos)
	{
		$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->set($datos);
	}

	function agregar_dt_talonario_bono_colaboracion($datos)
	{
		$id = $this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->nueva_fila($datos);
		$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->set_cursor($id);
	}	

	function eliminar_dt_talonario_bono_colaboracion($seleccion)
	{
		$id = $this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-PREMIO-SORTEO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_dt_premio_sorteo()
	{
		return $this->dep('dr_bono_colaboracion')->tabla('dt_premio_sorteo')->get_filas();		
	}
	function procesar_dt_premio_sorteo($datos)
	{
		$this->dep('dr_bono_colaboracion')->tabla('dt_premio_sorteo')->procesar_filas($datos);
	}


	//-----------------------------------------------------------------------------------
	//---- DR-BONO COLABORACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_nros_bono_colaboracion_nros ()	
	{
		if(!$this->dep('dr_nros_bono_colaboracion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_nros_bono_colaboracion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_nros_bono_colaboracion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	
	function guardar_dr_nros_bono_colaboracion_nros()
	{
		$this->dep('dr_nros_bono_colaboracion')->sincronizar();
	}

	function resetear_dr_nros_bono_colaboracion_nros()
	{
		$this->dep('dr_nros_bono_colaboracion')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-TALONARIO-BONO-COLABORACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_talonario_bono_colaboracion_nros($seleccion)
	{
		if(!$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	
	function resetear_dt_talonario_bono_colaboracion_nros()
	{
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->resetear();					// lee de la BD fisica y carga al datos relacion	
	}
	function set_cursor_dt_talonario_bono_colaboracion_nros($seleccion)
	{
		$id = $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->get_id_fila_condicion($seleccion);

		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_talonario_bono_colaboracion_nros()
	{
		return $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->hay_cursor();
	}

	function resetear_cursor_dt_talonario_bono_colaboracion_nros()
	{
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->resetear_cursor();
	}

	function get_dt_talonario_bono_colaboracion_nros()
	{
		return $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->get();
	}

	function set_dt_talonario_bono_colaboracion_nros($datos)
	{
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->set($datos);
	}

	function agregar_dt_talonario_bono_colaboracion_nros($datos)
	{
		$id = $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->nueva_fila($datos);
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->set_cursor($id);
	}	

	function eliminar_dt_talonario_bono_colaboracion_nros($seleccion)
	{
		$id = $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_bono_colaboracion')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-NROS-TALONARIO-BONO-COLABORACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function get_dt_talonario_nros_bono_colaboracion_nros_filtro($filtro)
	{
		return $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->get_filas($filtro);		
	}	

	function get_dt_talonario_nros_bono_colaboracion_nros()
	{
		return $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->get_filas();		
	}
	function procesar_dt_talonario_nros_bono_colaboracion_nros($datos)
	{
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->procesar_filas($datos);
	}
		
	function resetear_dt_talonario_nros_bono_colaboracion()
	{
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->resetear();					
	}

	function set_cursor_dt_talonario_nros_bono_colaboracion($seleccion)
	{
		$id = $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_talonario_nros_bono_colaboracion()
	{
		return $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->hay_cursor();
	}

	function resetear_cursor_dt_talonario_nros_bono_colaboracion()
	{
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->resetear_cursor();
	}

	function get_dt_talonario_nros_bono_colaboracion()
	{
		return $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->get();
	}

	function set_dt_talonario_nros_bono_colaboracion($datos)
	{
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->set($datos);
	}

	function agregar_dt_talonario_nros_bono_colaboracion($datos)
	{
		$id = $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->nueva_fila($datos);
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->set_cursor($id);
	}	

	function eliminar_dt_talonario_nros_bono_colaboracion($seleccion)
	{
		$id = $this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_nros_bono_colaboracion')->tabla('dt_talonario_nros_bono_colaboracion')->eliminar_fila($id[0]);
	}


	//-----------------------------------------------------------------------------------
	//---- DR-BONO COLABORACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_colonia ()	
	{
		if(!$this->dep('dr_colonia')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_colonia')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_colonia')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	
	function guardar_dr_colonia()
	{
		$this->dep('dr_colonia')->sincronizar();
	}

	function resetear_dr_colonia()
	{
		$this->dep('dr_colonia')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-TALONARIO-BONO-COLABORACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_inscripcion_colono($seleccion)
	{
		if(!$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	
	function resetear_dt_inscripcion_colono()
	{
		$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->resetear();					// lee de la BD fisica y carga al datos relacion	
	}
	function set_cursor_dt_inscripcion_colono($seleccion)
	{
		$id = $this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->get_id_fila_condicion($seleccion);

		$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->set_cursor($id[0]);
	}

	function hay_cursor_dt_inscripcion_colono()
	{
		return $this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->hay_cursor();
	}

	function resetear_cursor_dt_inscripcion_colono()
	{
		$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->resetear_cursor();
	}

	function get_dt_inscripcion_colono()
	{
		return $this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->get();
	}

	function set_dt_inscripcion_colono($datos)
	{
		$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->set($datos);
	}

	function agregar_dt_inscripcion_colono($datos)
	{
		$id = $this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->nueva_fila($datos);
		$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->set_cursor($id);
	}	

	function eliminar_dt_inscripcion_colono($seleccion)
	{
		$id = $this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_colonia')->tabla('dt_inscripcion_colono')->eliminar_fila($id[0]);
	}
	//-----------------------------------------------------------------------------------
	//---- DT-TELEFONOS-INSCRIPCION-COLONO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_dt_telefono_inscripcion_colono()
	{
		return $this->dep('dr_colonia')->tabla('dt_telefono_inscripcion_colono')->get_filas();
	}	
	function procesar_dt_telefono_inscripcion_colono($datos)
	{
		$this->dep('dr_colonia')->tabla('dt_telefono_inscripcion_colono')->procesar_filas($datos);
	}	

	//-----------------------------------------------------------------------------------
	//---- DR-ADMINISTRACIN-COLONIA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_administrar_colonia ()	
	{
		if(!$this->dep('dr_administrar_colonia')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_administrar_colonia')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_administrar_colonia')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	
	function guardar_dr_administrar_colonia()
	{
		$this->dep('dr_administrar_colonia')->sincronizar();
	}

	function resetear_dr_administrar_colonia()
	{
		$this->dep('dr_administrar_colonia')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-TALONARIO-BONO-COLABORACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_afiliacion_colonia($seleccion)
	{
		if(!$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	
	function resetear_dt_afiliacion_colonia()
	{
		$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->resetear();					// lee de la BD fisica y carga al datos relacion	
	}
	function set_cursor_dt_afiliacion_colonia($seleccion)
	{
		$id = $this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->get_id_fila_condicion($seleccion);

		$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_afiliacion_colonia()
	{
		return $this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->hay_cursor();
	}

	function resetear_cursor_dt_afiliacion_colonia()
	{
		$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->resetear_cursor();
	}

	function get_dt_afiliacion_colonia()
	{
		return $this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->get();
	}

	function set_dt_afiliacion_colonia($datos)
	{
		$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->set($datos);
	}

	function agregar_dt_afiliacion_colonia($datos)
	{
		$id = $this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->nueva_fila($datos);
		$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->set_cursor($id);
	}	

	function eliminar_dt_afiliacion_colonia($seleccion)
	{
		$id = $this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_administrar_colonia')->tabla('dt_afiliacion')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-INSCRIPCION-COLONO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_dt_inscripcion_colonos()
	{
		return $this->dep('dr_administrar_colonia')->tabla('dt_inscripcion_colono')->get_filas();
	}	
	function procesar_dt_inscripcion_colonos($datos)
	{
		$this->dep('dr_administrar_colonia')->tabla('dt_inscripcion_colono')->procesar_filas($datos);
	}	

}

?>