<?php
require_once('dao.php');
class ci_solicitud_reserva extends mupum_ci
{

	/*function ini()
	{
		$this->_calendario = new calendario2();
	}*/

	protected $s__dia;
	protected $s__fecha;
	protected $s__persona;

	function conf()
	{
		if (isset($this->s__dia))
		{
			$this->evento('procesar')->mostrar();
			$this->evento('cancelar')->mostrar();
		} else {
			$this->evento('procesar')->ocultar();
			$this->evento('cancelar')->ocultar();
		}
		
	}
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{

			$this->cn()->guardar_dr_reserva();
			$this->enviar_correo_reserva($this->s__persona[0]);
			$this->enviar_correo_reserva_mutual($this->s__persona[0]);
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			$mensaje= $error->get_mensaje_motor();
			
			toba::notificacion()->agregar('Tira el error '.$mensaje,'error');
			 		
		}
		$this->cn()->resetear_dr_reserva();
		$this->set_pantalla('pant_inicial');
		unset($this->s__dia);
	}

	function evt__cancelar()
	{
		unset($this->s__dia);
	}

	//-----------------------------------------------------------------------------------
	//---- calendario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__calendario(mupum_ei_calendario $calendario)
	{
		$datos = dao::cargar_calendario_reserva();
		$calendario->set_ver_contenidos(true);
		
		$nuevafecha = date ( 'Y-m-j' );
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

		$fecha_seleccionada = $dia['anio'].'-'.$dia['mes'].'-'.$dia['dia'];			
					
		$this->s__fecha  = $dia['dia'].'/'.$dia['mes'].'/'.$dia['anio'];
		$this->s__mes = $dia['mes'];
		$this->s__anio = $dia['anio'];	
		
		
		$hoy = date('Y-m-j');
		
		$datetime1 = date_create($hoy);
		$datetime2 = date_create($fecha_seleccionada);

		$interval = date_diff($datetime1, $datetime2);
		$dias = $interval->format('%R%a');
		$configuracion = dao::get_configuracion();

		$signo = substr($dias, 0, 1); 
		$dias = substr($dias, 1); 
			
		
		if ($signo == '+')
		{
			if ($dias <=  $configuracion['limite_dias_para_reserva'])
			{
				$this->s__dia['fecha'] = $fecha_seleccionada;


			} else {
				toba::notificacion()->agregar("No puede realizar una reserva con mas de: ".$configuracion['limite_dias_para_reserva']. " dias de anticipacion.",'info');
				unset($this->s__dia);
			}
		} else {
			toba::notificacion()->agregar("No puede realizar una reserva de una fecha anterior a la del dia de hoy.",'info');
			unset($this->s__dia);
		}


		/*$fecha = date('Y-m-j');
		$nuevafecha = strtotime ( '+60 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
		$hoy =  date("Y", strtotime($nuevafecha));  */

			
	}

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__pant_inicial(toba_ei_pantalla $pantalla)
	{
		if (empty($this->s__dia)) 
		{
			$pantalla->eliminar_dep('frm');	
			$pantalla->eliminar_dep('frm_detalle_pago');	
		}
	}

	function get_estados_segun_categoria()
	{
		return dao::get_listado_estado('RESERVA');
	}	

	function get_motivos_segun_categoria( $idinstalacion)
	{
		$where  =  'motivo_tipo_socio.idinstalacion='.$idinstalacion; 
		return dao::get_motivo_por_tipo_socio($where);

	}

	function get_fecha_seleccionada()
	{
		return quote($this->s__fecha);
	}

	function get_listado_instalacion_disponible($idafiliacion)
	{
		$fecha = quote("%{$this->s__dia['fecha']}%");

		return dao::get_listado_instalacion_disponible($idafiliacion, $fecha);
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	

	function evt__frm__modificacion($datos)
	{
		$estado = dao::get_listado_estado_reserva('confirmada');
		$datos['idestado'] = $estado[0]['idestado']; 

		$this->s__persona = dao::get_listado_socios('afiliacion.idafiliacion='.$datos['idafiliacion']);
		$instalacion = dao::get_listado_instalacion('instalacion.idinstalacion='.$datos['idinstalacion']);

		$motivo = dao::get_listado_motivo_por_tipo_socio('motivo_tipo_socio.idmotivo_tipo_socio='.$datos['idmotivo_tipo_socio']);

		$this->s__persona[0]['fecha'] = date("d/m/Y", strtotime( $datos['fecha']));
		$this->s__persona[0]['instalacion'] = $instalacion[0]['nombre']; 
		$this->s__persona[0]['motivo'] = $motivo[0]['motivo']; 
		$datos['monto_final'] = $datos['monto'];
		$this->cn()->agregar_dt_reserva($datos);

	}

	function evt__frm__cancelar()
	{
		unset($this->s__dia);
	}
	//-----------------------------------------------------------------------------------
	//---- frm_detalle_pago -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	/*function conf__frm_detalle_pago(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_detalle_pago();
		$form_ml->set_datos($datos);
	}*/

	function evt__frm_detalle_pago__modificacion($datos)
	{
		$this->cn()->procesar_dt_detalle_pago($datos);
	}

	function enviar_correo_reserva($persona)
	{
	    $atributos['email'] = $persona['correo'];
	    $fecha = $persona['fecha'];
	    $instalacion = $persona['instalacion'];
	    $motivo = $persona['motivo'];

	    //Armo el mail nuevo &oacute;
	    $asunto = "Reserva Confirmada";
	    
		$cuerpo_mail = "<p>Estimado/a: </p>".trim($persona['persona'])."<br>".
				"<p>Por medio del presente le informamos que la reserva a sido confirmada.</p> ".
				"<p>Los datos su reserva son:</p>".
				"Instalacion : ".$instalacion. "<br>".
				"Fecha: ".$fecha. "<br>".
				"Motivo: ".$motivo. "<br>".
				"Debe acercarse a la oficina de la mutual ubicada en Santa Catalina Nro 2379 para abonar su reserva.<br>".
				"Para cancelar la reserva debe comunicarse por telefono al numero: 376-4422787.<br>".
				"<p>Saludos ATTE .- MUPUM</p>".
				"<p>No responda este correo, fue generado por sistema. </p>";

        try 
        {
            $mail = new toba_mail(trim($persona['correo']), $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
            $mail->set_html(true);
            //--$mail->set_cc();
            $mail->enviar();
        } catch (toba_error $error) {
            $chupo = $error->get_mensaje_log();
            toba::notificacion()->agregar($chupo, 'info');
        }
	}	
	function enviar_correo_reserva_mutual($persona)
	{
		
		
	    $atributos['email'] = $persona['correo'];
	    $fecha = $persona['fecha'];
	    $instalacion = $persona['instalacion'];
	    $motivo = $persona['motivo'];

	    //Armo el mail nuevo &oacute;
	    $asunto = "Reserva Confirmada de ".trim($persona['persona']);
		$cuerpo_mail = "<p>El afiliado : </p>".trim($persona['persona'])."<br>".
				"<p>Tiene una reserva en: </p>".
				"Instalacion : ".$instalacion. "<br>".
				"Fecha: ".$fecha. "<br>".
				"Motivo: ".$motivo. "<br>";

        try 
        {
            $mail = new toba_mail('escalantegc@gmail.com ', $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
            $mail->set_html(true);
            //--$mail->set_cc();
            $mail->enviar();
        } catch (toba_error $error) {
            $chupo = $error->get_mensaje_log();
            toba::notificacion()->agregar($chupo, 'info');
        }
	}


	function ajax__traer_monto_senia($idmotivo_tipo_socio, toba_ajax_respuesta $respuesta)
	{
		$monto = dao::get_monto_porcentaje($idmotivo_tipo_socio);
		$respuesta->set($monto);	
	}
	



}
?>