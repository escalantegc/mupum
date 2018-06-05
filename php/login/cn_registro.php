<?php
class cn_registro extends mupum_cn
{
	function cargar_dr_registro()	
	{
		if(!$this->dep('dr_registro')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_registro')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_registro')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_registro()
	{
		$this->dep('dr_registro')->sincronizar();
	}

	function resetear_dr_registro()
	{
		$this->dep('dr_registro')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-PERSONA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_persona($seleccion)
	{
		if(!$this->dep('dr_registro')->tabla('dt_persona')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_registro')->tabla('dt_persona')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_registro')->tabla('dt_persona')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_persona($seleccion)
	{
		$id = $this->dep('dr_registro')->tabla('dt_persona')->get_id_fila_condicion($seleccion);
		$this->dep('dr_registro')->tabla('dt_persona')->set_cursor($id[0]);
	}	

	function existe_dt_persona($condicion)
	{
		$id = $this->dep('dr_registro')->tabla('dt_persona')->existe_fila_condicion($condicion);
		if ($id==1)
		{
			return 'existe';
		} else {
			return 'noexiste';
		}
	}
	
	function hay_cursor_dt_persona()
	{
		return $this->dep('dr_registro')->tabla('dt_persona')->hay_cursor();
	}

	function resetear_cursor_dt_persona()
	{
		$this->dep('dr_registro')->tabla('dt_persona')->resetear_cursor();
	}

	function get_dt_persona()
	{
		return $this->dep('dr_registro')->tabla('dt_persona')->get();
	}

	function set_dt_persona($datos)
	{
		$this->dep('dr_registro')->tabla('dt_persona')->set($datos);
	}

	function agregar_dt_persona($datos)
	{
		$id = $this->dep('dr_registro')->tabla('dt_persona')->nueva_fila($datos);
		$this->dep('dr_registro')->tabla('dt_persona')->set_cursor($id);
	}	

	function eliminar_dt_persona($seleccion)
	{
		$id = $this->dep('dr_registro')->tabla('dt_persona')->get_id_fila_condicion($seleccion);
		$this->dep('dr_registro')->tabla('dt_persona')->eliminar_fila($id[0]);
	}
	

	//-----------------------------------------------------------------------------------
	//---- DT-AFILACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_afiliacion($seleccion)
	{
		if(!$this->dep('dr_registro')->tabla('dt_afiliacion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_registro')->tabla('dt_afiliacion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_registro')->tabla('dt_afiliacion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_afiliacion($seleccion)
	{
		$id = $this->dep('dr_registro')->tabla('dt_afiliacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_registro')->tabla('dt_afiliacion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_afiliacion()
	{
		return $this->dep('dr_registro')->tabla('dt_afiliacion')->hay_cursor();
	}

	function resetear_cursor_dt_afiliacion()
	{
		$this->dep('dr_registro')->tabla('dt_afiliacion')->resetear_cursor();
	}

	function get_dt_afiliacion()
	{
		return $this->dep('dr_registro')->tabla('dt_afiliacion')->get();
	}

	function set_dt_afiliacion($datos)
	{
		$this->dep('dr_registro')->tabla('dt_afiliacion')->set($datos);
	}

	function agregar_dt_afiliacion($datos)
	{
		$id = $this->dep('dr_registro')->tabla('dt_afiliacion')->nueva_fila($datos);
		$this->dep('dr_registro')->tabla('dt_afiliacion')->set_cursor($id);
	}	

	function eliminar_dt_afiliacion($seleccion)
	{
		$id = $this->dep('dr_registro')->tabla('dt_afiliacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_registro')->tabla('dt_afiliacion')->eliminar_fila($id[0]);
	}
}

?>