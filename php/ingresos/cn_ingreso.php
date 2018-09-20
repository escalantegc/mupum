<?php
class cn_ingreso extends mupum_cn
{
	function cargar_dr_importacion()	
	{
		if(!$this->dep('dr_importacion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_importacion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_importacion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_importacion()
	{
		$this->dep('dr_importacion')->sincronizar();
	}

	function resetear_dr_importacion()
	{
		$this->dep('dr_importacion')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-PERSONA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_cabecera_cuota_societaria($seleccion)
	{
		if(!$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_cabecera_cuota_societaria($seleccion)
	{
		$id = $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->get_id_fila_condicion($seleccion);
		$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set_cursor($id[0]);
	}

	function hay_cursor_dt_cabecera_cuota_societaria()
	{
		return $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->hay_cursor();
	}

	function resetear_cursor_dt_cabecera_cuota_societaria()
	{
		$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->resetear_cursor();
	}

	function get_dt_cabecera_cuota_societaria()
	{
		return  $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->get();
	}	

	function get_dt_cabecera_cuota_societaria_sin_blob()
	{
		return $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->get();
	}

	function set_dt_cabecera_cuota_societaria($datos)
	{
		$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set($datos);

	}

	function agregar_dt_cabecera_cuota_societaria($datos)
	{
		$id = $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->nueva_fila($datos);
		$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set_cursor($id);

	}

	function eliminar_dt_cabecera_cuota_societaria($seleccion)
	{
		$id = $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->get_id_fila_condicion($seleccion);
		$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-TELEFONOS POR PERSONA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function procesar_dt_cuota_societaria($datos)
	{
		$this->dep('dr_importacion')->tabla('dt_cuota_societaria')->procesar_filas($datos);
	}	
	function get_dt_cuota_societaria()
	{
		return $this->dep('dr_importacion')->tabla('dt_cuota_societaria')->get_filas();
	}	
}

?>