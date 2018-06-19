<?php
class cn_configuracion extends mupum_cn
{
	function guardar_dr_configuracion()
	{
		$this->dep('dr_configuracion')->sincronizar();
	}

	function resetear_dr_configuracion()
	{
		$this->dep('dr_configuracion')->resetear();
	}
	//-----------------------------------------------------------------------------------
	//---- DT-TIPO-DOCUMENTO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_configuracion()
	{
	
		$this->dep('dr_configuracion')->tabla('dt_configuracion')->cargar();					// lee de la BD fisica y carga al datos relacion
		
	}
	function set_cursor_dt_configuracion($seleccion)
	{
		$id = $this->dep('dr_configuracion')->tabla('dt_configuracion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_configuracion')->tabla('dt_configuracion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_configuracion()
	{
		return $this->dep('dr_configuracion')->tabla('dt_configuracion')->hay_cursor();
	}

	function resetear_cursor_dt_configuracion()
	{
		$this->dep('dr_configuracion')->tabla('dt_configuracion')->resetear_cursor();
	}

	function get_dt_configuracion()
	{
		return $this->dep('dr_configuracion')->tabla('dt_configuracion')->get();
	}

	function set_dt_configuracion($datos)
	{
		$this->dep('dr_configuracion')->tabla('dt_configuracion')->set($datos);
	}

	function agregar_dt_configuracion($datos)
	{
		$id = $this->dep('dr_configuracion')->tabla('dt_configuracion')->nueva_fila($datos);
		$this->dep('dr_configuracion')->tabla('dt_configuracion')->set_cursor($id);
	}	

	function eliminar_dt_configuracion($seleccion)
	{
		$id = $this->dep('dr_configuracion')->tabla('dt_configuracion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_configuracion')->tabla('dt_configuracion')->eliminar_fila($id[0]);
	}	
}

?>