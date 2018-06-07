<?php
require_once('dao.php');
class ci_solicitud_reserva extends mupum_ci
{
	protected $s__dia;
	protected $s__fecha;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
	}

	function evt__cancelar()
	{
	}

	//-----------------------------------------------------------------------------------
	//---- calendario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__calendario(mupum_ei_calendario $calendario)
	{
		$datos = dao::cargar_calendario_reserva();
		$calendario->set_ver_contenidos(true);
		
		$fecha = date('Y-m-j');
		$nuevafecha = strtotime ( '+60 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
		$hoy =  date("Y", strtotime($nuevafecha));  

		$calendario->set_rango_anios(2016,$hoy);
		$calendario->set_datos($datos);
		$calendario->set_sab_seleccionable(true) ;
		$calendario->set_dom_seleccionable(true) ;
		$calendario->set_seleccionar_solo_dias_pasados(false) ;
		$calendario->set_mostrar_semanas(false) ;
		$calendario->set_resaltar_siempre_dia_actual(true) ;
	}

	function evt__calendario__seleccionar_dia($dia)
	{

		$this->s__dia['fecha'] = $dia['anio'].'-'.$dia['mes'].'-'.$dia['dia'];			
		$this->s__fecha = $dia['dia'].'/'.$dia['mes'].'/'.$dia['anio'];
		$this->s__mes = $dia['mes'];
		$this->s__anio = $dia['anio'];	
		$reserva['idsolicitud_reserva'] = $dia['idsolicitud_reserva'];
		if (isset($reserva['idsolicitud_reserva']))
		{
			$this->cargar_dt_reserva($reserva);
			$this->set_cursor_dt_reserva($reserva);
		}
		
	}

	function evt__calendario__seleccionar_semana($semana)
	{
	}

	function evt__calendario__cambiar_mes($mes)
	{
	}

	

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__pant_inicial(toba_ei_pantalla $pantalla)
	{
		if (empty($this->s__dia)) 
		{
			$pantalla->eliminar_dep('frm');	
		}
	}

	function get_estados_segun_categoria()
	{
		return dao::get_listado_estado('RESERVA');

	}	

	function get_motivos_segun_categoria()
	{
		return dao::get_listado_motivos('RESERVA');

	}

	function get_fecha_seleccionada()
	{
		return quote($this->s__fecha);
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(ei_frm_solicitud_reserva $form)
	{
		if ($this->cn()->hay_cursor_dt_reserva())
		{
			$datos = $this->cn()->get_dt_reserva();
			$form->set_datos($datos);
		}
	}

	function evt__frm__procesar($datos)
	{

		$this->cn()->agregar_dt_reserva($datos);
		try{
			$this->cn()->guardar_dr_reserva();
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			toba::notificacion()->agregar('Tira el error '.$sql_state,'error');
			 		
		}
		$this->cn()->resetear_dr_reserva();
		$this->set_pantalla('pant_inicial');
		unset($this->s__dia);
	}

	function evt__frm__baja()
	{
	}

	function evt__frm__cancelar()
	{
		unset($this->s__dia);
	}

}
?>