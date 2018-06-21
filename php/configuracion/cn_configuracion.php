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

	//-----------------------------------------------------------------------------------
	//---- DT-ENCABEZADO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_cabecera()
	{
		$this->dep('dr_configuracion')->tabla('dt_cabecera')->cargar();
	}
	function set_dt_cabecera($datos)
	{

		$this->dep('dr_configuracion')->tabla('dt_cabecera')->set($datos);

		if ($datos['logo']['name']!='') {
			  $fplogo1 = fopen($datos['logo']['tmp_name'], 'rb');

			  $this->dep('dr_configuracion')->tabla('dt_cabecera')->set_blob('logo', $fplogo1);
		 }		

	}	

	function get_dt_cabecera()
	{
	
		$datos = $this->dep('dr_configuracion')->tabla('dt_cabecera')->get();
		$id = $this->dep('dr_configuracion')->tabla('dt_cabecera')->get_cursor();
		$fp_logo1 = $this->dep('dr_configuracion')->tabla('dt_cabecera')->get_blob('logo', $id[0]);

 		if (isset($fp_logo1)) {
			$temp_nombre_archivo_logo = 'logo.jpg';
			$archivologo = toba::proyecto()->get_www($temp_nombre_archivo_logo);
			//ei_arbol($archivologo);
			$temp_archivo_logo = fopen($archivologo['path'], 'w');
			stream_copy_to_stream($fp_logo1, $temp_archivo_logo);
			fclose($temp_archivo_logo);
		                                        
			$datos['logo'] =  "<img src='{$archivologo['url']}' alt=\"Logo\" WIDTH=180 HEIGHT=130 >";
			
		}else {
			$datos['logo']   = null;
			//Agrego esto para cuando no existe imagen pero si registro
		}
 	
		return $datos;
				

	}
}

?>