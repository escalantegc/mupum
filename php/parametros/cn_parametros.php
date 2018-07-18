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

	//-----------------------------------------------------------------------------------
	//---- DT-PARENTESCO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_parentesco($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_parentesco')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_parentesco')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_parentesco')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_parentesco($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_parentesco')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_parentesco')->set_cursor($id[0]);
	}

	function hay_cursor_dt_parentesco()
	{
		return $this->dep('dr_parametros')->tabla('dt_parentesco')->hay_cursor();
	}

	function resetear_cursor_dt_parentesco()
	{
		$this->dep('dr_parametros')->tabla('dt_parentesco')->resetear_cursor();
	}

	function get_dt_parentesco()
	{
		return $this->dep('dr_parametros')->tabla('dt_parentesco')->get();
	}

	function set_dt_parentesco($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_parentesco')->set($datos);
	}

	function agregar_dt_parentesco($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_parentesco')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_parentesco')->set_cursor($id);
	}	

	function eliminar_dt_parentesco($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_parentesco')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_parentesco')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-CATEGORIA ESTADO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_categoria_estado($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_categoria_estado')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_categoria_estado')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_categoria_estado')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_categoria_estado($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_estado')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_categoria_estado')->set_cursor($id[0]);
	}

	function hay_cursor_dt_categoria_estado()
	{
		return $this->dep('dr_parametros')->tabla('dt_categoria_estado')->hay_cursor();
	}

	function resetear_cursor_dt_categoria_estado()
	{
		$this->dep('dr_parametros')->tabla('dt_categoria_estado')->resetear_cursor();
	}

	function get_dt_categoria_estado()
	{
		return $this->dep('dr_parametros')->tabla('dt_categoria_estado')->get();
	}

	function set_dt_categoria_estado($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_categoria_estado')->set($datos);
	}

	function agregar_dt_categoria_estado($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_estado')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_categoria_estado')->set_cursor($id);
	}	

	function eliminar_dt_categoria_estado($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_estado')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_categoria_estado')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-ESTADO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_estado($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_estado')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_estado')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_estado')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_estado($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_estado')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_estado')->set_cursor($id[0]);
	}

	function hay_cursor_dt_estado()
	{
		return $this->dep('dr_parametros')->tabla('dt_estado')->hay_cursor();
	}

	function resetear_cursor_dt_estado()
	{
		$this->dep('dr_parametros')->tabla('dt_estado')->resetear_cursor();
	}

	function get_dt_estado()
	{
		return $this->dep('dr_parametros')->tabla('dt_estado')->get();
	}

	function set_dt_estado($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_estado')->set($datos);
	}

	function agregar_dt_estado($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_estado')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_estado')->set_cursor($id);
	}	

	function eliminar_dt_estado($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_estado')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_estado')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-INSTALACION	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_instalacion($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_instalacion')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_instalacion')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_instalacion')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_instalacion($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_instalacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_instalacion')->set_cursor($id[0]);
	}

	function hay_cursor_dt_instalacion()
	{
		return $this->dep('dr_parametros')->tabla('dt_instalacion')->hay_cursor();
	}

	function resetear_cursor_dt_instalacion()
	{
		$this->dep('dr_parametros')->tabla('dt_instalacion')->resetear_cursor();
	}

	function get_dt_instalacion()
	{
		return $this->dep('dr_parametros')->tabla('dt_instalacion')->get();
	}

	function set_dt_instalacion($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_instalacion')->set($datos);
	}

	function agregar_dt_instalacion($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_instalacion')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_instalacion')->set_cursor($id);
	}	

	function eliminar_dt_instalacion($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_instalacion')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_instalacion')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-CATEGORIA DE MOTIVO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_categoria_motivo($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_categoria_motivo')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_categoria_motivo')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_categoria_motivo')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_categoria_motivo($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_motivo')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_categoria_motivo')->set_cursor($id[0]);
	}

	function hay_cursor_dt_categoria_motivo()
	{
		return $this->dep('dr_parametros')->tabla('dt_categoria_motivo')->hay_cursor();
	}

	function resetear_cursor_dt_categoria_motivo()
	{
		$this->dep('dr_parametros')->tabla('dt_categoria_motivo')->resetear_cursor();
	}

	function get_dt_categoria_motivo()
	{
		return $this->dep('dr_parametros')->tabla('dt_categoria_motivo')->get();
	}

	function set_dt_categoria_motivo($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_categoria_motivo')->set($datos);
	}

	function agregar_dt_categoria_motivo($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_motivo')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_categoria_motivo')->set_cursor($id);
	}	

	function eliminar_dt_categoria_motivo($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_motivo')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_categoria_motivo')->eliminar_fila($id[0]);
	}		

	//-----------------------------------------------------------------------------------
	//---- DT-MOTIVO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_motivo($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_motivo')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_motivo')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_motivo')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_motivo($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_motivo')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_motivo')->set_cursor($id[0]);
	}

	function hay_cursor_dt_motivo()
	{
		return $this->dep('dr_parametros')->tabla('dt_motivo')->hay_cursor();
	}

	function resetear_cursor_dt_motivo()
	{
		$this->dep('dr_parametros')->tabla('dt_motivo')->resetear_cursor();
	}

	function get_dt_motivo()
	{
		return $this->dep('dr_parametros')->tabla('dt_motivo')->get();
	}

	function set_dt_motivo($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_motivo')->set($datos);
	}

	function agregar_dt_motivo($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_motivo')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_motivo')->set_cursor($id);
	}	

	function eliminar_dt_motivo($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_motivo')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_motivo')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-MOTIVO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_motivo_tipo_socio($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_motivo_tipo_socio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->set_cursor($id[0]);
	}

	function hay_cursor_dt_motivo_tipo_socio()
	{
		return $this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->hay_cursor();
	}

	function resetear_cursor_dt_motivo_tipo_socio()
	{
		$this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->resetear_cursor();
	}

	function get_dt_motivo_tipo_socio()
	{
		return $this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->get();
	}

	function set_dt_motivo_tipo_socio($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->set($datos);
	}

	function agregar_dt_motivo_tipo_socio($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->set_cursor($id);
	}	

	function eliminar_dt_motivo_tipo_socio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_motivo_tipo_socio')->eliminar_fila($id[0]);
	}	
	//-----------------------------------------------------------------------------------
	//---- DT-CLAUSTRO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_claustro($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_claustro')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_claustro')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_claustro')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_claustro($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_claustro')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_claustro')->set_cursor($id[0]);
	}

	function hay_cursor_dt_claustro()
	{
		return $this->dep('dr_parametros')->tabla('dt_claustro')->hay_cursor();
	}

	function resetear_cursor_dt_claustro()
	{
		$this->dep('dr_parametros')->tabla('dt_claustro')->resetear_cursor();
	}

	function get_dt_claustro()
	{
		return $this->dep('dr_parametros')->tabla('dt_claustro')->get();
	}

	function set_dt_claustro($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_claustro')->set($datos);
	}

	function agregar_dt_claustro($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_claustro')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_claustro')->set_cursor($id);
	}	

	function eliminar_dt_claustro($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_claustro')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_claustro')->eliminar_fila($id[0]);
	}		

	//-----------------------------------------------------------------------------------
	//---- DT-UNIDAD ACADEMICA	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_unidad_academica($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_unidad_academica')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_unidad_academica')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_unidad_academica')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_unidad_academica($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_unidad_academica')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_unidad_academica')->set_cursor($id[0]);
	}

	function hay_cursor_dt_unidad_academica()
	{
		return $this->dep('dr_parametros')->tabla('dt_unidad_academica')->hay_cursor();
	}

	function resetear_cursor_dt_unidad_academica()
	{
		$this->dep('dr_parametros')->tabla('dt_unidad_academica')->resetear_cursor();
	}

	function get_dt_unidad_academica()
	{
		return $this->dep('dr_parametros')->tabla('dt_unidad_academica')->get();
	}

	function set_dt_unidad_academica($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_unidad_academica')->set($datos);
	}

	function agregar_dt_unidad_academica($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_unidad_academica')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_unidad_academica')->set_cursor($id);
	}	

	function eliminar_dt_unidad_academica($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_unidad_academica')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_unidad_academica')->eliminar_fila($id[0]);
	}	


	//-----------------------------------------------------------------------------------
	//---- DT-UNIDAD ACADEMICA	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_forma_pago($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_forma_pago')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_forma_pago')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_forma_pago')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_forma_pago($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_forma_pago')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_forma_pago')->set_cursor($id[0]);
	}

	function hay_cursor_dt_forma_pago()
	{
		return $this->dep('dr_parametros')->tabla('dt_forma_pago')->hay_cursor();
	}

	function resetear_cursor_dt_forma_pago()
	{
		$this->dep('dr_parametros')->tabla('dt_forma_pago')->resetear_cursor();
	}

	function get_dt_forma_pago()
	{
		return $this->dep('dr_parametros')->tabla('dt_forma_pago')->get();
	}

	function set_dt_forma_pago($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_forma_pago')->set($datos);
	}

	function agregar_dt_forma_pago($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_forma_pago')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_forma_pago')->set_cursor($id);
	}	

	function eliminar_dt_forma_pago($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_forma_pago')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_forma_pago')->eliminar_fila($id[0]);
	}	
	//-----------------------------------------------------------------------------------
	//---- DT-CATEGORIA-COMERCIO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_categoria_comercio($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_categoria_comercio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_categoria_comercio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_categoria_comercio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_categoria_comercio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_comercio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_categoria_comercio')->set_cursor($id[0]);
	}

	function hay_cursor_dt_categoria_comercio()
	{
		return $this->dep('dr_parametros')->tabla('dt_categoria_comercio')->hay_cursor();
	}

	function resetear_cursor_dt_categoria_comercio()
	{
		$this->dep('dr_parametros')->tabla('dt_categoria_comercio')->resetear_cursor();
	}

	function get_dt_categoria_comercio()
	{
		return $this->dep('dr_parametros')->tabla('dt_categoria_comercio')->get();
	}

	function set_dt_categoria_comercio($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_categoria_comercio')->set($datos);
	}

	function agregar_dt_categoria_comercio($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_comercio')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_categoria_comercio')->set_cursor($id);
	}	

	function eliminar_dt_categoria_comercio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_categoria_comercio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_categoria_comercio')->eliminar_fila($id[0]);
	}	
	//-----------------------------------------------------------------------------------
	//---- DT-COMERCIO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_comercio($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_comercio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_comercio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_comercio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_comercio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_comercio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_comercio')->set_cursor($id[0]);
	}

	function hay_cursor_dt_comercio()
	{
		return $this->dep('dr_parametros')->tabla('dt_comercio')->hay_cursor();
	}

	function resetear_cursor_dt_comercio()
	{
		$this->dep('dr_parametros')->tabla('dt_comercio')->resetear_cursor();
	}

	function get_dt_comercio()
	{
		return $this->dep('dr_parametros')->tabla('dt_comercio')->get();
	}

	function set_dt_comercio($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_comercio')->set($datos);
	}

	function agregar_dt_comercio($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_comercio')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_comercio')->set_cursor($id);
	}	

	function eliminar_dt_comercio($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_comercio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_comercio')->eliminar_fila($id[0]);
	}

	//-----------------------------------------------------------------------------------
	//---- DT-COMERCIO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_concepto($seleccion)
	{
		if(!$this->dep('dr_parametros')->tabla('dt_concepto')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_parametros')->tabla('dt_concepto')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_parametros')->tabla('dt_concepto')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_concepto($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_concepto')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_concepto')->set_cursor($id[0]);
	}

	function hay_cursor_dt_concepto()
	{
		return $this->dep('dr_parametros')->tabla('dt_concepto')->hay_cursor();
	}

	function resetear_cursor_dt_concepto()
	{
		$this->dep('dr_parametros')->tabla('dt_concepto')->resetear_cursor();
	}

	function get_dt_concepto()
	{
		return $this->dep('dr_parametros')->tabla('dt_concepto')->get();
	}

	function set_dt_concepto($datos)
	{
		$this->dep('dr_parametros')->tabla('dt_concepto')->set($datos);
	}

	function agregar_dt_concepto($datos)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_concepto')->nueva_fila($datos);
		$this->dep('dr_parametros')->tabla('dt_concepto')->set_cursor($id);
	}	

	function eliminar_dt_concepto($seleccion)
	{
		$id = $this->dep('dr_parametros')->tabla('dt_concepto')->get_id_fila_condicion($seleccion);
		$this->dep('dr_parametros')->tabla('dt_concepto')->eliminar_fila($id[0]);
	}	
	
	//-----------------------------------------------------------------------------------
	//---- DR-CONVENIO -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dr_convenio($seleccion)
	{
		if(!$this->dep('dr_convenio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_convenio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_convenio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function guardar_dr_convenio()
	{
		$this->dep('dr_convenio')->sincronizar();
	}

	function resetear_dr_convenio()
	{
		$this->dep('dr_convenio')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- DT-CONVENIO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function cargar_dt_convenio($seleccion)
	{
		if(!$this->dep('dr_convenio')->tabla('dt_convenio')->esta_cargada())
		{				// verifica si esta cargada el datos relacion			
			if(!isset($seleccion))
			{
				$this->dep('dr_convenio')->tabla('dt_convenio')->cargar();					// lee de la BD fisica y carga al datos relacion
			}else{
				$this->dep('dr_convenio')->tabla('dt_convenio')->cargar($seleccion);				// lee de la BD fisica y carga al datos relacion
			}
		}
	}
	function set_cursor_dt_convenio($seleccion)
	{
		$id = $this->dep('dr_convenio')->tabla('dt_convenio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_convenio')->tabla('dt_convenio')->set_cursor($id[0]);
	}

	function hay_cursor_dt_convenio()
	{
		return $this->dep('dr_convenio')->tabla('dt_convenio')->hay_cursor();
	}

	function resetear_cursor_dt_convenio()
	{
		$this->dep('dr_convenio')->tabla('dt_convenio')->resetear_cursor();
	}

	function get_dt_convenio()
	{
		return $this->dep('dr_convenio')->tabla('dt_convenio')->get();
	}

	function set_dt_convenio($datos)
	{
		$this->dep('dr_convenio')->tabla('dt_convenio')->set($datos);
	}

	function agregar_dt_convenio($datos)
	{
		$id = $this->dep('dr_convenio')->tabla('dt_convenio')->nueva_fila($datos);
		$this->dep('dr_convenio')->tabla('dt_convenio')->set_cursor($id);
	}	

	function eliminar_dt_convenio($seleccion)
	{
		$id = $this->dep('dr_convenio')->tabla('dt_convenio')->get_id_fila_condicion($seleccion);
		$this->dep('dr_convenio')->tabla('dt_convenio')->eliminar_fila($id[0]);
	}	

	//-----------------------------------------------------------------------------------
	//---- DT-COMERCIO POR CONVENIO	 -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function get_dt_comercios_por_convenio()
	{
		return $this->dep('dr_convenio')->tabla('dt_comercios_por_convenio')->get_filas();
	}

	function procesar_dt_comercios_por_convenio($datos)
	{
		$this->dep('dr_convenio')->tabla('dt_comercios_por_convenio')->procesar_filas($datos);
	}
}

?>