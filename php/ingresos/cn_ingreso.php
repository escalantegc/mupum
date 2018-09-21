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
		$datos =  $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->get();
		$fp_archivo = $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->get_blob('archivo');

		if (isset($fp_archivo)) 
 		{
 			$periodo = str_replace("/", "-", $datos['periodo']);
 			$temp_nombre_archivo_logo = $periodo.'_0547.txt';
			$archivologo = toba::proyecto()->get_www($temp_nombre_archivo_logo);
			//ei_arbol($archivologo);
			$temp_archivo_logo = fopen($archivologo['path'], 'w');
			stream_copy_to_stream($fp_archivo, $temp_archivo_logo);
			fclose($temp_archivo_logo);
		                                        
		 	$datos['archivo'] = "<a href='{$archivologo['url']}' TARGET='_blank' >Descargar</a>";
			
		}else {
			$datos['archivo']   = null;
			//Agrego esto para cuando no existe imagen pero si registro
		}
		return $datos;
	}	

	function get_dt_cabecera_cuota_societaria_sin_blob()
	{
		return $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->get();
	}

	function set_dt_cabecera_cuota_societaria($datos)
	{
		$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set($datos);

		if (isset($datos['archivo']))
		{
			if ($datos['archivo']['tmp_name']!='') {
			
				$fparchivo = fopen($datos['archivo']['tmp_name'], 'rb');
				$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set_blob('archivo', $fparchivo);
		 	} else {
				$fp = null;
				$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set_blob( 'archivo', $fp);
					
			}
		}
	}

	function agregar_dt_cabecera_cuota_societaria($datos)
	{
		$id = $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->nueva_fila($datos);
		$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set_cursor($id);

		if (isset($datos['archivo']))
		{
			if ($datos['archivo']['tmp_name']!='') {
				  //Se subio una imagen
				  $fp = fopen($datos['archivo']['tmp_name'], 'rb');
				  $this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set_blob('archivo', $fp);
				 
			 } else {
					$fp =null;
					$this->dep('dr_importacion')->tabla('dt_cabecera_cuota_societaria')->set_blob( 'archivo', $fp);	
			}
		}	
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

	function agregar_dt_cuota_societaria($datos)
	{
		return $this->dep('dr_importacion')->tabla('dt_cuota_societaria')->nueva_fila($datos);
	}	
}

?>