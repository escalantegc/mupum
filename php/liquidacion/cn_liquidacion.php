<?php
class cn_liquidacion extends mupum_cn
{

	//-----------------------------------------------------------------------------------
	//---- DR-LIQUIDACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_liquidacion ()	
	{
		if(!$this->dep('dr_liquidacion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_liquidacion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_liquidacion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	
	function guardar_dr_liquidacion()
	{
		$this->dep('dr_liquidacion')->sincronizar();
	}

	function resetear_dr_liquidacion()
	{
		$this->dep('dr_liquidacion')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-CABECERA-LIQUIDACION-----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_cabecera_liquidacion($seleccion)
	{
		if(!$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}	
	function resetear_dt_cabecera_liquidacion()
	{
		$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->resetear();					// lee de la BD fisica y carga al datos relacion	
	}
	function set_cursor_dt_cabecera_liquidacion($seleccion)
	{
		$id = $this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_cabecera_liquidacion()
	{
		return $this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->hay_cursor();
	}

	function resetear_cursor_dt_cabecera_liquidacion()
	{
		$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->resetear_cursor();
	}

	function get_dt_cabecera_liquidacion()
	{
		return $this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->get();
	}

	function set_dt_cabecera_liquidacion($datos)
	{
		$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->set($datos);
		if (isset($datos['archivo']))
		{
			if ($datos['archivo']['tmp_name']!='') {
			
				$fparchivo = fopen($datos['archivo']['tmp_name'], 'rb');
				
				$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->set_blob('archivo', $fparchivo);
		 	} else {
				$fp = null;
				$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->set_blob( 'archivo', $fp);
					
			}
		}
	}

	function agregar_dt_cabecera_liquidacion($datos)
	{
		$id = $this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->nueva_fila($datos);
		$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->set_cursor($id);
	}	

	function eliminar_dt_cabecera_liquidacion($seleccion)
	{
		$id = $this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_liquidacion')->tabla('dt_cabecera_liquidacion')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-DETALLE-LIQUIDACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function procesar_dt_detalle_liquidacion($datos)
	{
		$this->dep('dr_liquidacion')->tabla('dt_detalle_liquidacion')->procesar_filas($datos);
	}

	function get_dt_detalle_liquidacion()
	{
		return $this->dep('dr_liquidacion')->tabla('dt_detalle_liquidacion')->get_filas();
	}

	function agregar_dt_detalle_liquidacion($datos)
	{
		return $this->dep('dr_liquidacion')->tabla('dt_detalle_liquidacion')->nueva_fila($datos);
	}

	function set_cursor_dt_detalle_liquidacion($seleccion)
	{
		$id = $this->dep('dr_liquidacion')->tabla('dt_detalle_liquidacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_liquidacion')->tabla('dt_detalle_liquidacion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_detalle_liquidacion()
	{
		return $this->dep('dr_liquidacion')->tabla('dt_detalle_liquidacion')->hay_cursor();
	}

	function resetear_cursor_dt_detalle_liquidacion()
	{
		$this->dep('dr_liquidacion')->tabla('dt_detalle_liquidacion')->resetear_cursor();
	}

	function set_dt_detalle_liquidacion($datos)
	{
		$this->dep('dr_liquidacion')->tabla('dt_detalle_liquidacion')->set($datos);
		
	}
	
}

?>