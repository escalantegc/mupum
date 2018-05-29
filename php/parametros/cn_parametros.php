<?php
class cn_parametros extends mupum_cn
{
	//-----------------------------------------------------------------------------------
	//---- DR-PARAMETROS -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_parametros($seleccion)
	{
		if(!$this->dep('dr_parametros')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_parametros()
	{
		$this->dep('dr_parametros')->sincronizar();
	}

	function resetear_dr_parametros()
	{
		$this->dep('dr_parametros')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-TIPO-DOCUMENTO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_tipo_documento($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_tipo_documento')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_tipo_documento')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_tipo_documento')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_tipo_documento($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_documento')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_tipo_documento')->set_cursor($id[0]);
	}

	function hay_cursor_dt_tipo_documento()
	{
		return $this->dep('dr_parametros')->tabla('dt_tipo_documento')->hay_cursor();
	}

	function resetear_cursor_dt_tipo_documento()
	{
		$this->dep('dr_parametros')->tabla('dt_tipo_documento')->resetear_cursor();
	}

	function get_dt_tipo_documento()
	{
		return $this->dep('dr_parametros')->tabla('dt_tipo_documento')->get();
	}

	function set_dt_tipo_documento($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_tipo_documento')->set($datos);
	}

	function agregar_dt_tipo_documento($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_documento')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_tipo_documento')->set_cursor($id);
	}	

	function eliminar_dt_tipo_documento($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_documento')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_tipo_documento')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-TIPO-TELEFONO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_tipo_telefono($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_tipo_telefono')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_tipo_telefono')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_tipo_telefono')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_tipo_telefono($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_telefono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_tipo_telefono')->set_cursor($id[0]);
	}

	function hay_cursor_dt_tipo_telefono()
	{
		return $this->dep('dr_parametros')->tabla('dt_tipo_telefono')->hay_cursor();
	}

	function resetear_cursor_dt_tipo_telefono()
	{
		$this->dep('dr_parametros')->tabla('dt_tipo_telefono')->resetear_cursor();
	}

	function get_dt_tipo_telefono()
	{
		return $this->dep('dr_parametros')->tabla('dt_tipo_telefono')->get();
	}

	function set_dt_tipo_telefono($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_tipo_telefono')->set($datos);
	}

	function agregar_dt_tipo_telefono($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_telefono')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_tipo_telefono')->set_cursor($id);
	}	

	function eliminar_dt_tipo_telefono($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_telefono')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_tipo_telefono')->eliminar_fila($id[0]);
	}
	//-----------------------------------------------------------------------------------
	//---- DT-TIPO-SOCIO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_tipo_socio($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_tipo_socio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_tipo_socio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_tipo_socio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_tipo_socio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_socio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_tipo_socio')->set_cursor($id[0]);
	}

	function hay_cursor_dt_tipo_socio()
	{
		return $this->dep('dr_parametros')->tabla('dt_tipo_socio')->hay_cursor();
	}

	function resetear_cursor_dt_tipo_socio()
	{
		$this->dep('dr_parametros')->tabla('dt_tipo_socio')->resetear_cursor();
	}

	function get_dt_tipo_socio()
	{
		return $this->dep('dr_parametros')->tabla('dt_tipo_socio')->get();
	}

	function set_dt_tipo_socio($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_tipo_socio')->set($datos);
	}

	function agregar_dt_tipo_socio($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_socio')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_tipo_socio')->set_cursor($id);
	}	

	function eliminar_dt_tipo_socio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_tipo_socio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_tipo_socio')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-PAIS -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_pais($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_pais')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_pais')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_pais')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_pais($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_pais')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_pais')->set_cursor($id[0]);
	}

	function hay_cursor_dt_pais()
	{
		return $this->dep('dr_parametros')->tabla('dt_pais')->hay_cursor();
	}

	function resetear_cursor_dt_pais()
	{
		$this->dep('dr_parametros')->tabla('dt_pais')->resetear_cursor();
	}

	function get_dt_pais()
	{
		return $this->dep('dr_parametros')->tabla('dt_pais')->get();
	}

	function set_dt_pais($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_pais')->set($datos);
	}

	function agregar_dt_pais($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_pais')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_pais')->set_cursor($id);
	}	

	function eliminar_dt_pais($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_pais')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_pais')->eliminar_fila($id[0]);
	}
	//-----------------------------------------------------------------------------------
	//---- DT-PROVINCIA	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_provincia($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_provincia')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_provincia')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_provincia')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_provincia($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_provincia')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_provincia')->set_cursor($id[0]);
	}

	function hay_cursor_dt_provincia()
	{
		return $this->dep('dr_parametros')->tabla('dt_provincia')->hay_cursor();
	}

	function resetear_cursor_dt_provincia()
	{
		$this->dep('dr_parametros')->tabla('dt_provincia')->resetear_cursor();
	}

	function get_dt_provincia()
	{
		return $this->dep('dr_parametros')->tabla('dt_provincia')->get();
	}

	function set_dt_provincia($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_provincia')->set($datos);
	}

	function agregar_dt_provincia($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_provincia')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_provincia')->set_cursor($id);
	}	

	function eliminar_dt_provincia($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_provincia')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_provincia')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-LOCALIDAD	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_localidad($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_localidad')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_localidad')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_localidad')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_localidad($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_localidad')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_localidad')->set_cursor($id[0]);
	}

	function hay_cursor_dt_localidad()
	{
		return $this->dep('dr_parametros')->tabla('dt_localidad')->hay_cursor();
	}

	function resetear_cursor_dt_localidad()
	{
		$this->dep('dr_parametros')->tabla('dt_localidad')->resetear_cursor();
	}

	function get_dt_localidad()
	{
		return $this->dep('dr_parametros')->tabla('dt_localidad')->get();
	}

	function set_dt_localidad($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_localidad')->set($datos);
	}

	function agregar_dt_localidad($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_localidad')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_localidad')->set_cursor($id);
	}	

	function eliminar_dt_localidad($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_localidad')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_localidad')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-NIVEL-ESTUDIO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_nivel_estudio($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_nivel_estudio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_nivel_estudio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_nivel_estudio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_nivel_estudio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_nivel_estudio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_nivel_estudio')->set_cursor($id[0]);
	}

	function hay_cursor_dt_nivel_estudio()
	{
		return $this->dep('dr_parametros')->tabla('dt_nivel_estudio')->hay_cursor();
	}

	function resetear_cursor_dt_nivel_estudio()
	{
		$this->dep('dr_parametros')->tabla('dt_nivel_estudio')->resetear_cursor();
	}

	function get_dt_nivel_estudio()
	{
		return $this->dep('dr_parametros')->tabla('dt_nivel_estudio')->get();
	}

	function set_dt_nivel_estudio($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_nivel_estudio')->set($datos);
	}

	function agregar_dt_nivel_estudio($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_nivel_estudio')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_nivel_estudio')->set_cursor($id);
	}	

	function eliminar_dt_nivel_estudio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_nivel_estudio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_nivel_estudio')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-ESTADO-CIVIL	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_estado_civil($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_estado_civil')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_estado_civil')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_estado_civil')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_estado_civil($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_estado_civil')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_estado_civil')->set_cursor($id[0]);
	}

	function hay_cursor_dt_estado_civil()
	{
		return $this->dep('dr_parametros')->tabla('dt_estado_civil')->hay_cursor();
	}

	function resetear_cursor_dt_estado_civil()
	{
		$this->dep('dr_parametros')->tabla('dt_estado_civil')->resetear_cursor();
	}

	function get_dt_estado_civil()
	{
		return $this->dep('dr_parametros')->tabla('dt_estado_civil')->get();
	}

	function set_dt_estado_civil($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_estado_civil')->set($datos);
	}

	function agregar_dt_estado_civil($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_estado_civil')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_estado_civil')->set_cursor($id);
	}	

	function eliminar_dt_estado_civil($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_estado_civil')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_estado_civil')->eliminar_fila($id[0]);
	}	
}

?>