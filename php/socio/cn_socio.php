<?php
class cn_socio extends mupum_cn
{
	function cargar_dr_socio()	
	{
		if(!$this->dep('dr_socio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_socio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_socio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_socio()
	{
		$this->dep('dr_socio')->sincronizar();
	}

	function resetear_dr_socio()
	{
		$this->dep('dr_socio')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-PERSONA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_persona($seleccion)
	{
		if(!$this->dep('dr_socio')->tabla('dt_persona')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_socio')->tabla('dt_persona')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_socio')->tabla('dt_persona')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_persona($seleccion)
	{
		$id = $this->dep('dr_socio')->tabla('dt_persona')->get_id_fila_condicion($seleccion);
		$this->dep('dr_socio')->tabla('dt_persona')->set_cursor($id[0]);
	}

	function hay_cursor_dt_persona()
	{
		return $this->dep('dr_socio')->tabla('dt_persona')->hay_cursor();
	}

	function resetear_cursor_dt_persona()
	{
		$this->dep('dr_socio')->tabla('dt_persona')->resetear_cursor();
	}

	function get_dt_persona()
	{
		return $this->dep('dr_socio')->tabla('dt_persona')->get();
	}

	function set_dt_persona($datos)
	{
		$this->dep('dr_socio')->tabla('dt_persona')->set($datos);
	}

	function agregar_dt_persona($datos)
	{
		$id = $this->dep('dr_socio')->tabla('dt_persona')->nueva_fila($datos);
		$this->dep('dr_socio')->tabla('dt_persona')->set_cursor($id);
	}	

	function eliminar_dt_persona($seleccion)
	{
		$id = $this->dep('dr_socio')->tabla('dt_persona')->get_id_fila_condicion($seleccion);
		$this->dep('dr_socio')->tabla('dt_persona')->eliminar_fila($id[0]);
	}
	//-----------------------------------------------------------------------------------
	//---- DT-FAMILIA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function procesar_dt_familia($datos)
	{
		//ei_arbol($datos);
		$this->dep('dr_socio')->tabla('dt_familia')->procesar_filas($datos);

		/*if (isset($datos['archivo'])){
			if ($datos['archivo']['tmp_name']!='') 
			{
				//Se subio una imagen
				$fp_archivo = fopen($datos['archivo']['tmp_name'], 'rb');
				$this->dep('dr_mis_proyectos')->tabla('dt_requisitos_proyecto')->set_blob('archivo', $fp_archivo);
			}  else {
				$fp_archivo = null;
				$this->dep('dr_mis_proyectos')->tabla('dt_requisitos_proyecto')->set_blob('archivo', $fp_archivo);
			}
		}*/


	}	


	function get_dt_familia()
	{
		//ei_arbol($this->dep('dr_socio')->tabla('dt_familia')->get_filas());
		return $this->dep('dr_socio')->tabla('dt_familia')->get_filas();

		/*$fp_archivo = $this->dep('dr_mis_proyectos')->tabla('dt_requisitos_proyecto')->get_blob('archivo');

				
		if (isset($fp_archivo)) 
		{
			$temp_nombre_doc =  trim($datos['nombre']).$datos['id_proy'].'.'.trim($datos['extension']);
			$doc = toba::proyecto()->get_www_temp($temp_nombre_doc);
			$temp_doc = fopen($doc['path'], 'w');
			stream_copy_to_stream($fp_archivo, $temp_doc);
			
			fclose($temp_doc);
			$datos['archivo'] = "<a href='{$doc['url']}' TARGET='_blank' >Descargar</a>";
			//$datos['huella'] = 'Tama&ntilde;o: '.$tamano_huella.' kb';
		} else {
			$datos['archivo']   = null;
			//Agrego esto para cuando no existe imagen pero si registro
		}  
		return $datos;
*/
	}		

	//-----------------------------------------------------------------------------------
	//---- DT-TELEFONOS POR PERSONA -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function procesar_dt_telefono_por_persona($datos)
	{
		$this->dep('dr_socio')->tabla('dt_telefono_por_persona')->procesar_filas($datos);
	}	
	function get_dt_telefono_por_persona()
	{
		return $this->dep('dr_socio')->tabla('dt_telefono_por_persona')->get_filas();
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-AFILACION -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_afiliacion($seleccion)
	{
		if(!$this->dep('dr_socio')->tabla('dt_afiliacion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_socio')->tabla('dt_afiliacion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_socio')->tabla('dt_afiliacion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_afiliacion($seleccion)
	{
		$id = $this->dep('dr_socio')->tabla('dt_afiliacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_socio')->tabla('dt_afiliacion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_afiliacion()
	{
		return $this->dep('dr_socio')->tabla('dt_afiliacion')->hay_cursor();
	}

	function resetear_cursor_dt_afiliacion()
	{
		$this->dep('dr_socio')->tabla('dt_afiliacion')->resetear_cursor();
	}

	function get_dt_afiliacion()
	{
		return $this->dep('dr_socio')->tabla('dt_afiliacion')->get();
	}

	function set_dt_afiliacion($datos)
	{
		$this->dep('dr_socio')->tabla('dt_afiliacion')->set($datos);
	}

	function agregar_dt_afiliacion($datos)
	{
		$id = $this->dep('dr_socio')->tabla('dt_afiliacion')->nueva_fila($datos);
		$this->dep('dr_socio')->tabla('dt_afiliacion')->set_cursor($id);
	}	

	function eliminar_dt_afiliacion($seleccion)
	{
		$id = $this->dep('dr_socio')->tabla('dt_afiliacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_socio')->tabla('dt_afiliacion')->eliminar_fila($id[0]);
	}
}

?>