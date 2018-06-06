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
	function guardar_dr_solicitudes()
	{
		$this->dep('dr_solicitudes')->sincronizar();
	}

	function resetear_dr_solicitudes()
	{
		$this->dep('dr_solicitudes')->resetear();
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
	//---- DT-AFILACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_reserva($seleccion)
	{
		if(!$this->dep('dr_solicitudes')->tabla('dt_reserva')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_solicitudes')->tabla('dt_reserva')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_solicitudes')->tabla('dt_reserva')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_reserva($seleccion)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_reserva')->get_id_fila_condicion($seleccion);
		$this->dep('dr_solicitudes')->tabla('dt_reserva')->set_cursor($id[0]);
	}

	function hay_cursor_dt_reserva()
	{
		return $this->dep('dr_solicitudes')->tabla('dt_reserva')->hay_cursor();
	}

	function resetear_cursor_dt_reserva()
	{
		$this->dep('dr_solicitudes')->tabla('dt_reserva')->resetear_cursor();
	}

	function get_dt_reserva()
	{
		return $this->dep('dr_solicitudes')->tabla('dt_reserva')->get();
	}

	function set_dt_reserva($datos)
	{
		$this->dep('dr_solicitudes')->tabla('dt_reserva')->set($datos);
	}

	function agregar_dt_reserva($datos)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_reserva')->nueva_fila($datos);
		$this->dep('dr_solicitudes')->tabla('dt_reserva')->set_cursor($id);
	}	

	function eliminar_dt_reserva($seleccion)
	{
		$id = $this->dep('dr_solicitudes')->tabla('dt_reserva')->get_id_fila_condicion($seleccion);
		$this->dep('dr_solicitudes')->tabla('dt_reserva')->eliminar_fila($id[0]);
	}
}

?>