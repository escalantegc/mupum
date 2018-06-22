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
		$datos = $this->dep('dr_socio')->tabla('dt_persona')->get();
		$id = $this->dep('dr_socio')->tabla('dt_persona')->get_cursor();
		$fp_logo1 = $this->dep('dr_socio')->tabla('dt_persona')->get_blob('foto',$id[0]);

 		if (isset($fp_logo1)) 
 		{
 			$temp_nombre_archivo_logo = 'foto_'.$datos['nro_documento'].'.jpg';
			$archivologo = toba::proyecto()->get_www($temp_nombre_archivo_logo);
			//ei_arbol($archivologo);
			$temp_archivo_logo = fopen($archivologo['path'], 'w');
			stream_copy_to_stream($fp_logo1, $temp_archivo_logo);
			fclose($temp_archivo_logo);
		                                        
			$datos['foto'] =  "<img src='{$archivologo['url']}' alt=\"Foto de Perfil\" WIDTH=180 HEIGHT=130 >";
			
		}else {
			$datos['foto']   = null;
			//Agrego esto para cuando no existe imagen pero si registro
		}
 		
		return $datos;
	}	

	function get_dt_persona_sin_blob()
	{
		return $this->dep('dr_socio')->tabla('dt_persona')->get();

	}

	function set_dt_persona($datos)
	{
		$this->dep('dr_socio')->tabla('dt_persona')->set($datos);

		if (isset($datos['foto']))
		{
			if ($datos['foto']['tmp_name']!='') {
			
				$fpfoto = fopen($datos['foto']['tmp_name'], 'rb');
				$this->dep('dr_socio')->tabla('dt_persona')->set_blob('foto', $fpfoto);
		 	} else {
				$fp = null;
				$this->dep('dr_socio')->tabla('dt_persona')->set_blob( 'foto', $fp);
					
			}
		}
	}

	function agregar_dt_persona($datos)
	{
		$id = $this->dep('dr_socio')->tabla('dt_persona')->nueva_fila($datos);
		$this->dep('dr_socio')->tabla('dt_persona')->set_cursor($id);

		if (isset($datos['foto']))
		{
			if ($datos['foto']['tmp_name']!='') {
				  //Se subio una imagen
				  $fp = fopen($datos['foto']['tmp_name'], 'rb');
				  $this->dep('dr_socio')->tabla('dt_persona')->set_blob('foto', $fp);
				 
			 } else {
					$fp =null;
					$this->dep('dr_socio')->tabla('dt_persona')->set_blob( 'foto', $fp);	
			}
		}	
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
	
		foreach ($datos as $dato) 
		{
			if (isset($dato['archivo']))
			{
				if ($dato['archivo']['tmp_name']!='') 
				{
					//Se subio una imagen
					$fp_archivo = fopen($dato['archivo']['tmp_name'], 'rb');
					$this->dep('dr_socio')->tabla('dt_familia')->set_blob('archivo', $fp_archivo,$dato['x_dbr_clave']);
				}  else {
					$fp_archivo = null;
					$this->dep('dr_socio')->tabla('dt_familia')->set_blob('archivo', $fp_archivo,$dato['x_dbr_clave']);
				}
			}
			
		}

	}	


	function get_dt_familia()
	{
		//ei_arbol($this->dep('dr_socio')->tabla('dt_familia')->get_filas());
		$datos= $this->dep('dr_socio')->tabla('dt_familia')->get_filas();

		
		$familiares = array();
		foreach ($datos as $dato) 
		{
			$fp_archivo = $this->dep('dr_socio')->tabla('dt_familia')->get_blob('archivo',$dato['x_dbr_clave']);
		

				
			if (isset($fp_archivo)) 
			{
				$temp_nombre_doc = 'certificacion'.$dato['idpersona_familia'].'.pdf';
				$doc = toba::proyecto()->get_www_temp($temp_nombre_doc);
				$temp_doc = fopen($doc['path'], 'w');
				stream_copy_to_stream($fp_archivo, $temp_doc);
				
				fclose($temp_doc);
				$dato['archivo'] = "<a href='{$doc['url']}' TARGET='_blank' >Descargar</a>";
				//$datos['huella'] = 'Tama&ntilde;o: '.$tamano_huella.' kb';
			} else {
				$dato['archivo']   = null;
				//Agrego esto para cuando no existe imagen pero si registro
			}  
			$familiares[$dato['x_dbr_clave']] = $dato;
		}
		return $familiares;

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