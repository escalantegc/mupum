<?php
require_once('dao.php');
class ci_administrar_bonos_colaboracion extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			if(!toba::notificacion()->verificar_mensajes())
			{
				$this->cn()->guardar_dr_nros_bono_colaboracion_nros();
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			}
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El tipo de subsidio esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_descripcion'))
			{
				toba::notificacion()->agregar("El tipo de subsidio ya esta registrado.",'info');
				
			} 
			
		}
		$this->cn()->resetear_cursor_dt_talonario_nros_bono_colaboracion();
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_nros_bono_colaboracion_nros();
		$this->set_pantalla('pant_inicial');

	}

	function evt__volver()
	{
		$this->cn()->resetear_cursor_dt_talonario_nros_bono_colaboracion();
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver_cancelar()
	{
		$this->cn()->resetear_dr_nros_bono_colaboracion_nros();
		$this->set_pantalla('pant_inicial');
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_talonario_bono_colaboracion($this->s__where);
		}else{
			$datos = dao::get_listado_talonario_bono_colaboracion();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_nros_bono_colaboracion_nros($seleccion);
		$this->cn()->set_cursor_dt_talonario_bono_colaboracion_nros($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	function evt__cuadro__ver($seleccion)
	{
		$this->cn()->cargar_dr_nros_bono_colaboracion_nros($seleccion);
		$this->cn()->set_cursor_dt_talonario_bono_colaboracion_nros($seleccion);
		$this->set_pantalla('pant_visualizar');
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro_vendidos --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_vendidos(mupum_ei_cuadro $cuadro)
	{
		$talonario = $this->cn()->get_dt_talonario_bono_colaboracion_nros();
		$datos = dao::get_nros_vendidos($talonario['idtalonario_bono_colaboracion']);
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_vendidos__deshacer($seleccion)
	{

		$this->cn()->set_cursor_dt_talonario_nros_bono_colaboracion($seleccion);
		$datos['disponible'] = 1;
		$datos['idafiliacion'] = null;
		$datos['idpersona_externa'] = null;
		$datos['persona_externa'] = 0;
		$datos['pagado'] = 0;
		$datos['fecha_compra'] = null;

		$this->cn()->set_dt_talonario_nros_bono_colaboracion($datos);

		try{
			$this->cn()->guardar_dr_nros_bono_colaboracion_nros();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El tipo de subsidio esta siendo referenciado, no puede eliminarlo",'error');
				
			} 		
		}
		$this->cn()->resetear_cursor_dt_talonario_nros_bono_colaboracion();
		$this->set_pantalla('pant_edicion');
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
	//---- frm_ml_nros_bonos ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_nros_bonos(mupum_ei_formulario_ml $form_ml)
	{
		$filtro['pagado'] = 0;
		$datos = $this->cn()->get_dt_talonario_nros_bono_colaboracion_nros_filtro($filtro);
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_nros_bonos__modificacion($datos)
	{
		$nros = array();
		foreach ($datos as $dato) 
		{	
			if (($dato['idafiliacion']!= '') or ($dato['idpersona_externa']!= '') )
			{
				$dato['disponible'] = 0;
				$nros[] = $dato;		
			}
		 
		}
		$this->cn()->procesar_dt_talonario_nros_bono_colaboracion_nros($nros);
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_disponibles -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_disponibles(mupum_ei_cuadro $cuadro)
	{
		$talonario = $this->cn()->get_dt_talonario_bono_colaboracion_nros();
		$datos = dao::get_nros_disponibles($talonario['idtalonario_bono_colaboracion']);
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_disponibles__vender($seleccion)
	{
		$this->cn()->set_cursor_dt_talonario_nros_bono_colaboracion($seleccion);
		$this->set_pantalla('pant_edicion_nro');
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_talonario_nros_bono_colaboracion())
		{
			$datos = $this->cn()->get_dt_talonario_nros_bono_colaboracion();

			$datos['fecha_compra'] = date("Y-m-d"); 
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_talonario_nros_bono_colaboracion())
		{
			$total_por_consumir = $datos['monto_bono'];
			///--$total_consumido = dao::get_total_consumido_en_bono_por_convenio_por_socio($datos['idafiliacion'],$datos['idconvenio']);
			//--$maximo_por_convenio = dao::get_monto_maximo_mensual_convenio($datos['idconvenio']); 
			
			$periodo = dao::sacar_periodo_fecha($datos['fecha_compra']);
			$estado_situacion = dao::get_total_estado_situacion($periodo,$datos['idafiliacion']);
			$configuracion = dao::get_configuracion();
			$limite_socio = $configuracion['limite_por_socio'];


			//--$total = $total_por_consumir + $total_consumido;

			$estado_total = $estado_situacion + $total_por_consumir;  
			if ($estado_total <= $limite_socio)
			{
				$this->cn()->set_dt_talonario_nros_bono_colaboracion($datos);
			} else {

				toba::notificacion()->agregar("El afiliado lleva consumido en este periodo : $".$estado_situacion. ", mas el valor del bono : $".round($total_por_consumir,2). " .Supera el limite maximo permitido por periodo por socio en la mutual de : $" .$limite_socio ,'info');
			}
			
		}
	}

	function ajax__es_planilla($idfp, toba_ajax_respuesta $respuesta)
	{
		$fp = dao::get_listado_forma_pago('idforma_pago = '.$idfp);
		
		$forma_pago['planilla'] = 'no';
		if ($fp[0]['planilla']==1)
		{
			$forma_pago['planilla'] = 'si';
		}
		$respuesta->set($forma_pago);	
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_vendidos_ver ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_vendidos_ver(mupum_ei_cuadro $cuadro)
	{
		$talonario = $this->cn()->get_dt_talonario_bono_colaboracion_nros();
		$datos = dao::get_nros_vendidos($talonario['idtalonario_bono_colaboracion']);
		$cuadro->set_datos($datos);
	}





}
?>