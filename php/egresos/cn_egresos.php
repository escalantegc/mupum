<?php
class cn_egresos extends mupum_cn
{
	function cargar_dr_gastos()	
	{
		if(!$this->dep('dr_gastos')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_gastos')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_gastos')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_gastos()
	{
		$this->dep('dr_gastos')->sincronizar();
	}

	function resetear_dr_gastos()
	{
		$this->dep('dr_gastos')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-PERSONA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_gasto_infraestructura($seleccion)
	{
		if(!$this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_gasto_infraestructura($seleccion)
	{
		$id = $this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->get_id_fila_condicion($seleccion);
		$this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->set_cursor($id[0]);
	}

	function hay_cursor_dt_gasto_infraestructura()
	{
		return $this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->hay_cursor();
	}

	function resetear_cursor_dt_gasto_infraestructura()
	{
		$this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->resetear_cursor();
	}

	function get_dt_gasto_infraestructura()
	{
		return  $this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->get();
	}	

	function get_dt_gasto_infraestructura_sin_blob()
	{
		return $this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->get();
	}

	function set_dt_gasto_infraestructura($datos)
	{
		$this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->set($datos);

	}

	function agregar_dt_gasto_infraestructura($datos)
	{
		$id = $this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->nueva_fila($datos);
		$this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->set_cursor($id);

	}

	function eliminar_dt_gasto_infraestructura($seleccion)
	{
		$id = $this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->get_id_fila_condicion($seleccion);
		$this->dep('dr_gastos')->tabla('dt_gasto_infraestructura')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-TELEFONOS POR PERSONA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function procesar_dt_detalle_pago($datos)
	{
		$this->dep('dr_gastos')->tabla('dt_detalle_pago')->procesar_filas($datos);
	}	
	function get_dt_detalle_pago()
	{
		return $this->dep('dr_gastos')->tabla('dt_detalle_pago')->get_filas();
	}	
}

?>