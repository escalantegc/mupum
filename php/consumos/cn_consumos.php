<?php
class cn_consumos extends mupum_cn
{
	function cargar_dr_consumos()	
	{
		if(!$this->dep('dr_consumos')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumos')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumos')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_consumos()
	{
		$this->dep('dr_consumos')->sincronizar();
	}

	function resetear_dr_consumos()
	{
		$this->dep('dr_consumos')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-CONSUMO-BONO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_consumo_bono($seleccion)
	{
		if(!$this->dep('dr_consumos')->tabla('dt_consumo_bono')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumos')->tabla('dt_consumo_bono')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumos')->tabla('dt_consumo_bono')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_consumo_bono($seleccion)
	{
		$id = $this->dep('dr_consumos')->tabla('dt_consumo_bono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumos')->tabla('dt_consumo_bono')->set_cursor($id[0]);
	}

	function hay_cursor_dt_consumo_bono()
	{
		return $this->dep('dr_consumos')->tabla('dt_consumo_bono')->hay_cursor();
	}

	function resetear_cursor_dt_consumo_bono()
	{
		$this->dep('dr_consumos')->tabla('dt_consumo_bono')->resetear_cursor();
	}

	function get_dt_consumo_bono()
	{
		return $this->dep('dr_consumos')->tabla('dt_consumo_bono')->get();
		
	}	

	function get_dt_consumo_bono_sin_blob()
	{
		return $this->dep('dr_consumos')->tabla('dt_consumo_bono')->get();

	}

	function set_dt_consumo_bono($datos)
	{
		$this->dep('dr_consumos')->tabla('dt_consumo_bono')->set($datos);

	}

	function agregar_dt_consumo_bono($datos)
	{
		$id = $this->dep('dr_consumos')->tabla('dt_consumo_bono')->nueva_fila($datos);
		$this->dep('dr_consumos')->tabla('dt_consumo_bono')->set_cursor($id);

	}

	function eliminar_dt_consumo_bono($seleccion)
	{
		$id = $this->dep('dr_consumos')->tabla('dt_consumo_bono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumos')->tabla('dt_consumo_bono')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-CONSUMO-TICKET -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_consumo_ticket($seleccion)
	{
		if(!$this->dep('dr_consumos')->tabla('dt_consumo_ticket')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_consumos')->tabla('dt_consumo_ticket')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_consumos')->tabla('dt_consumo_ticket')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_consumo_ticket($seleccion)
	{
		$id = $this->dep('dr_consumos')->tabla('dt_consumo_ticket')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumos')->tabla('dt_consumo_ticket')->set_cursor($id[0]);
	}

	function hay_cursor_dt_consumo_ticket()
	{
		return $this->dep('dr_consumos')->tabla('dt_consumo_ticket')->hay_cursor();
	}

	function resetear_cursor_dt_consumo_ticket()
	{
		$this->dep('dr_consumos')->tabla('dt_consumo_ticket')->resetear_cursor();
	}

	function get_dt_consumo_ticket()
	{
		return $this->dep('dr_consumos')->tabla('dt_consumo_ticket')->get();
		
	}	

	function get_dt_consumo_ticket_sin_blob()
	{
		return $this->dep('dr_consumos')->tabla('dt_consumo_ticket')->get();

	}

	function set_dt_consumo_ticket($datos)
	{
		$this->dep('dr_consumos')->tabla('dt_consumo_ticket')->set($datos);

	}

	function agregar_dt_consumo_ticket($datos)
	{
		$id = $this->dep('dr_consumos')->tabla('dt_consumo_ticket')->nueva_fila($datos);
		$this->dep('dr_consumos')->tabla('dt_consumo_ticket')->set_cursor($id);

	}

	function eliminar_dt_consumo_ticket($seleccion)
	{
		$id = $this->dep('dr_consumos')->tabla('dt_consumo_ticket')->get_id_fila_condicion($seleccion);
		$this->dep('dr_consumos')->tabla('dt_consumo_ticket')->eliminar_fila($id[0]);
	}
}

?>