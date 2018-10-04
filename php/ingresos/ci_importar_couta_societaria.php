<?php
require_once('dao.php');
class ci_importar_couta_societaria extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	protected $s__cuotas;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_importacion();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			toba::notificacion()->agregar($mensaje_log,'error');
		}
		/*$this->cn()->resetear_dr_importacion();
		$this->set_pantalla('pant_inicial');*/
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_importacion();
		$this->set_pantalla('pant_inicial');
		unset($this->s__cuotas);
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_cabecera_cuota_societaria($this->s__where);
		} else {
			$datos = dao::get_listado_cabecera_cuota_societaria();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_importacion($seleccion);
		$this->cn()->set_cursor_dt_cabecera_cuota_societaria($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_importacion($seleccion);
		$this->cn()->eliminar_dt_cabecera_cuota_societaria($seleccion);
			try{
			$this->cn()->guardar_dr_importacion();
			toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
			
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			toba::notificacion()->agregar($mensaje_log,'error');
		}
		$this->cn()->resetear_dr_importacion();
		
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro_cuotas ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_cuotas(mupum_ei_cuadro $cuadro)
	{
		$datos = $this->cn()->get_dt_cuota_societaria();
		$this->pantalla()->eliminar_evento('procesar');
		if (count($this->s__cuotas) > 0)
		{
			$cuadro->set_datos($datos);
			$this->pantalla()->agregar_evento('procesar');

		}
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
		if ($this->cn()->hay_cursor_dt_cabecera_cuota_societaria())
		{
			$datos = $this->cn()->get_dt_cabecera_cuota_societaria();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_cabecera_cuota_societaria())
		{
			$this->cn()->set_dt_cabecera_cuota_societaria($datos);
		} else {
			$this->cn()->agregar_dt_cabecera_cuota_societaria($datos);
		}
		$this->s__cuotas = $this->manipular_archivo($datos);

		foreach ($this->s__cuotas as $cuota) 
		{
			if (isset($cuota['idafiliacion']) and isset($cuota['idpersona']))
			{
				$this->cn()->agregar_dt_cuota_societaria($cuota);			
			}
			
		}
	}

	function manipular_archivo($cabecera)
	{
		$path = $cabecera['archivo']['tmp_name'];
		if (($mapuche = fopen($path , "r")) !== FALSE) 
		{
			$cuotas = array();
			while(!feof($mapuche)) 
			{
				$linea = fgets($mapuche);
				$legajo =  substr($linea, 0, 6);
				$legajo = ltrim($legajo, "0");
				$legajo = quote("%{$legajo}%");

				
				$afiliado = dao::get_datos_persona_afiliada_legajo($legajo);

				$datos['idafiliacion'] = $afiliado[0]['idafiliacion'];
				$datos['idpersona'] = $afiliado[0]['idpersona'];
				$datos['socio'] = $afiliado[0]['persona'];
				
				$datos['legajo'] =  ltrim(substr($linea, 0, 6));
				$datos['cargo'] =  substr($linea, 6, 6);
				$datos['apellido'] =  substr($linea, 12, 20);
				$datos['nombres'] =  substr($linea, 32, 20);
				$datos['tipo_documento'] =  substr($linea, 52, 4);
				$datos['nro_documento'] =  substr($linea, 56, 9);
				$datos['monto'] =  substr($linea, 65, 10);
				$datos['idconcepto_liquidacion'] =  $cabecera['idconcepto_liquidacion'];
				$cuotas[] = $datos;
			}
			
			return $cuotas;
			fclose($mapuche);
		}
	}
	function evt__validar()
	{
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	



}
?>