<?php
require_once('dao.php');
class ci_generar_liquidacion extends mupum_ci
{
	public $s__datos_liquidacion;
	public $s__datos_conciliacion;
	public $s__nombrearchivo;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_liquidacion();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			toba::notificacion()->agregar($mensaje_log,'error');
		}
		$this->cn()->resetear_dr_liquidacion();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_liquidacion();
		$this->set_pantalla('pant_inicial');
		unset($this->s__datos_liquidacion);
		unset($this->s__datos_conciliacion);
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}
	function evt__validar()
	{
		//$this->cn()->resetear_dr_liquidacion();
		//unset($this->s__datos_liquidacion);
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_cabecera_liquidacion($this->s__where);
		} else {
			$datos = dao::get_listado_cabecera_liquidacion();
		}
		
	
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__ver($seleccion)
	{
		$this->cn()->cargar_dr_liquidacion($seleccion);
		$this->cn()->set_cursor_dt_cabecera_liquidacion($seleccion);
		$this->set_pantalla('pantalla_ver');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_liquidacion($seleccion);
		$this->cn()->eliminar_dt_cabecera_liquidacion($seleccion);
			try{
			$this->cn()->guardar_dr_liquidacion();
			toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
			
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			toba::notificacion()->agregar($mensaje_log,'error');
		}
		$this->cn()->resetear_dr_liquidacion();
	}
	
	function evt__cuadro__conciliar($seleccion)
	{
		$this->cn()->cargar_dr_liquidacion($seleccion);
		$this->cn()->set_cursor_dt_cabecera_liquidacion($seleccion);
		$this->set_pantalla('pantalla_conso');
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(mupum_ei_filtro $filtro)
	{
		if(isset($this->s__datos_filtro))
		{
			$filtro->set_datos($this->s__datos_filtro);
			$this->s__where = $filtro->get_sql_where();
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_cabecera_liquidacion())
		{
			$datos = $this->cn()->get_dt_cabecera_liquidacion();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{

		if ($this->cn()->hay_cursor_dt_cabecera_liquidacion())
		{
			$this->cn()->set_dt_cabecera_liquidacion($datos);
		} else {
			$datos['usuario'] = toba::usuario()->get_id();
			$datos['fecha_liquidacion'] = date("d-m-Y"); 
			$datos['liquidado'] = 1;
			$this->cn()->agregar_dt_cabecera_liquidacion($datos);
		}

		$concepto = dao::get_listado_concepto_liquidacion('concepto_liquidacion.idconcepto_liquidacion = '.$datos['idconcepto_liquidacion']);

		switch (trim($concepto[0]['codigo'])) {
			case '0549':
				$this->s__datos_liquidacion = dao::get_listado_ingresos_0549($datos['periodo']);
				break;			
			case '0548':
				$this->s__datos_liquidacion = dao::get_listado_ingresos_0548($datos['periodo']);
				break;			
			case '0550':
				$this->s__datos_liquidacion = dao::get_listado_ingresos_0550($datos['periodo']);
				break;
		}

		
	}
	

	/*function conf__pant_edicion(toba_ei_pantalla $pantalla)
	{
		if (empty($this->s__datos_liquidacion)) 
		{
			$pantalla->eliminar_dep('cuadro_liquidacion');	
		}
	}*/
	//-----------------------------------------------------------------------------------
	//---- cuadro_liquidacion -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_liquidacion(mupum_ei_cuadro $cuadro)
	{
		$this->pantalla()->eliminar_evento('procesar');
		
		if (count($this->s__datos_liquidacion) > 0)
		{
			$cuadro->set_datos($this->s__datos_liquidacion);
			$cuadro->descolapsar();
			$this->pantalla()->agregar_evento('procesar');
		} else{
			$cuadro->colapsar();
		}
	}

	function evt__cuadro_liquidacion__seleccion($datos)
	{
		foreach ($datos as $dato) 
		{

			$this->cn()->agregar_dt_detalle_liquidacion($dato);
			
		}
	}

	

	//-----------------------------------------------------------------------------------
	//---- cuadro_ver_liquidacion -------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_ver_liquidacion(mupum_ei_cuadro $cuadro)
	{
		$datos = $this->cn()->get_dt_detalle_liquidacion();
		$cuadro->set_datos($datos);
		
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ver ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ver(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_cabecera_liquidacion())
		{
			$datos = $this->cn()->get_dt_cabecera_liquidacion();
			$form->set_datos($datos);
		}
	}


	function evt__cuadro__exportar($seleccion)
	{
		$this->cn()->cargar_dr_liquidacion($seleccion);
		$this->cn()->set_cursor_dt_cabecera_liquidacion($seleccion);
		$cabecera = $this->cn()->get_dt_cabecera_liquidacion();
		$concepto_liquidacion = dao::get_codigo_concepto_liquidacion($cabecera['idconcepto_liquidacion']);
		$datos = $this->cn()->get_dt_detalle_liquidacion();

		$descuentos = array();
		foreach ($datos as $dato) 
		{
			$afiliado = dao::get_datos_persona_afiliada_para_archivo($dato['idafiliacion']);
			$dato['monto'] = number_format($dato['monto'] , 2, '.', ''); ;

			$descuentos[] = array_merge((array) $dato,(array) $afiliado);
		}	
		

		$periodo = str_replace("/", "-", $cabecera['periodo']);
		$this->s__nombrearchivo = $concepto_liquidacion."_".$periodo.".txt";
		$file = fopen(toba::proyecto()->get_path()."/www/archivos/".$this->s__nombrearchivo, "w");

	 	foreach ($descuentos as $descuento) 
	 	{

	 		$linea =str_pad($descuento['legajo'], 6, "0", STR_PAD_LEFT) .
							str_pad($descuento['apellido'], 20).
							str_pad($descuento['nombres'], 20). 
							str_pad($descuento['tipodocumento'], 4). 
							str_pad($descuento['nro_documento'], 9,"0", STR_PAD_LEFT) . 
							str_pad($descuento['monto'], 10,"0", STR_PAD_LEFT). 
							str_pad(trim($descuento['concepto']), 4, "0", STR_PAD_LEFT).
							str_pad($descuento['cuil'], 11,"0", STR_PAD_LEFT).
							'N';	
			fwrite($file, $linea . PHP_EOL);
	 	}

		$archivo = toba::proyecto()->get_www('archivos/'.$this->s__nombrearchivo);
		//ei_arbol($archivo);
		$enlace = "<a href='{$archivo['url']}' TARGET='_blank'>Descargar</a>";
		$cabecera['archivo']['tmp_name'] = $archivo['path'];		

		$cabecera['exportado'] = 1;
		$this->cn()->set_dt_cabecera_liquidacion($cabecera);
		try{
			$this->cn()->guardar_dr_liquidacion();
			toba::notificacion()->agregar("El archivo se ha generado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			toba::notificacion()->agregar($mensaje_log,'error');
		}
		$this->cn()->resetear_dr_liquidacion();
	}


	//-----------------------------------------------------------------------------------
	//---- frm_consolidacion ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_consolidacion(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_cabecera_liquidacion())
		{
			$datos = $this->cn()->get_dt_cabecera_liquidacion();
			$form->set_datos($datos);
		}

	}

	function evt__frm_consolidacion__modificacion($datos)
	{
		$this->s__datos_conciliacion = $this->realizar_conciliacion($datos['archivo_unam']['tmp_name']);
		if ($this->cn()->hay_cursor_dt_cabecera_liquidacion())
		{
			$this->cn()->set_dt_cabecera_liquidacion($datos);
		} else {
			$datos['conciliado'] = 1;
			$this->cn()->agregar_dt_cabecera_liquidacion($datos);
		}
	}

	function realizar_conciliacion($path)
	{
		$file = fopen($path, "r") or exit("No se puede abrir el archivo");
		//Output a line of the file until the end is reached
		$descontando = array();
		while(!feof($file))
		{
			$linea = fgets($file);
			$vec['legajo'] = substr($linea, 0,6); 
			$vec['monto'] = substr($linea,65,10); 
			$descontando[] = $vec;
		}
		return $descontando;
		fclose($file);
	}


	//-----------------------------------------------------------------------------------
	//---- cuadro_conciliacion ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_conciliacion(mupum_ei_cuadro $cuadro)
	{
		$datos = $this->cn()->get_dt_detalle_liquidacion();

		$conciliacion = $this->s__datos_conciliacion;

		$conciliado = array();
		foreach ($conciliacion as $conso) 
		{	
			$legajo = intval($conso['legajo']);

			$legajo = (string) $legajo;
			
			$legajo = quote("%{$legajo}%");
			$afiliado = dao::get_datos_persona_afiliada_legajo($legajo);
			//--ei_arbol($afiliado);
			foreach ($datos as $dato) 
			{
				if ($afiliado[0]['idafiliacion'] == $dato['idafiliacion'])
				{
					$listo['idafiliacion'] = $dato['idafiliacion'];
					$listo['monto'] = $dato['monto'];
					$listo['persona'] = $dato['persona'];
					$listo['saldo'] = floatval($dato['monto']) - floatval($conso['monto']);
					$conciliado[] = $listo;
					break;
				}
			}
		}
		return $conciliado;	
	}

}
?>