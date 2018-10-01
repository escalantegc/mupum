<?php
require_once('dao.php');
class ci_inscripcion_colonos extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_colonia();
			$datos = $this->cn()->get_dt_inscripcion_colono();
			$colonia = dao::get_datos_configuracion_colonia($datos['idconfiguracion_colonia']);
			//$inscripcion = dao::get_listado_inscripcion_colono('inscripcion_colono.idafiliacion = '.$datos['idafiliacion'] .' and inscripcion_colono.idpersona_familia= '.$datos['idpersona_familia']);

			$socio = dao::get_datos_persona_afiliada($datos['idafiliacion']);
			$familiar = dao::get_datos_familiar($datos['idpersona_familia']);
			$inscripcion['titular'] = $socio[0]['persona'];
			$inscripcion['correo'] = $socio[0]['correo'];
		    $inscripcion['colono'] = $familiar[0]['familiar_titular'];

		    $inscripcion['monto'] = $datos['monto'];
		    $inscripcion['monto_inscripcion'] = $datos['monto_inscripcion'];
		    $inscripcion['porcentaje_inscripcion'] = $datos['porcentaje_inscripcion'];
/*
		    $fecha_inicio = $colonia[0]['fecha_inicio'];
		    $fecha_fin = $colonia[0]['fecha_fin'];
		    $domicilio = $colonia[0]['domicilio'];
		    $concentracion = $colonia[0]['concentracion'];
		    $salida = $colonia[0]['salida'];
		    $llegada = $colonia[0]['llegada'];
		    $finalizacion = $colonia[0]['finalizacion'];*/
		    $datos_correo = array_merge((array)$colonia[0], (array)$inscripcion); 
		  
		  	$this->enviar_correo_constancia_inscripcion($datos_correo);
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_inscripcion_colono'))
			{
				toba::notificacion()->agregar("Este colono ya se encuentra inscripto.",'info');
	
			} 
			
		}
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$cantidad = dao::get_cantidad_configuracion_colonia_vigentes();
		if ($cantidad>0)
		{
			$cupo = dao::get_cupo_configuracion_colonia();
			$cantidad_inscriptos = dao::get_cantidad_colonos_inscriptos();
			$disponible =$cupo - $cantidad_inscriptos; 
			if ($cantidad_inscriptos < $cupo)
			{
				$this->set_pantalla('pant_edicion');	
				toba::notificacion()->agregar("Se encuentran disponibles " .$disponible. " vacantes para inscripcion de colonos.",'info');
			} else {
				toba::notificacion()->agregar("La vacantes de inscripcion ha llegado al cupo maximo de :".$cupo. ". No se aceptan mas inscriptos",'info');
			}
				
		} else{
			toba::notificacion()->agregar("Por el momento no se encuentran disponibles las inscripciones a colonia.",'info');
		}
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_inscripcion_colono($this->s__where);
		}else{
			$datos = dao::get_listado_inscripcion_colono();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_colonia($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_colono($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_colonia($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_colono($seleccion);
		$datos = $this->cn()->get_dt_inscripcion_colono();
		$this->cn()->eliminar_dt_inscripcion_colono($seleccion);
		try{
			$colonia = dao::get_datos_configuracion_colonia($datos['idconfiguracion_colonia']);
			$inscripcion = dao::get_listado_inscripcion_colono('inscripcion_colono.idafiliacion = '.$datos['idafiliacion'] .' and inscripcion_colono.idpersona_familia= '.$datos['idpersona_familia']);

		    $datos_correo = array_merge((array)$colonia[0], (array)$inscripcion[0]); 
		  	$datos_correo['fecha_baja'] = date('d/m/Y');
		  	$this->enviar_correo_baja_inscripcion($datos_correo);

			$this->cn()->guardar_dr_colonia();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("No puede borrar al inscripcion del colono, la misma tiene plan de pago.",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_colonia();
		$this->set_pantalla('pant_inicial');
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
		if ($this->cn()->hay_cursor_dt_inscripcion_colono())
		{
			$datos = $this->cn()->get_dt_inscripcion_colono();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_inscripcion_colono())
		{
			$this->cn()->set_dt_inscripcion_colono($datos);
		} else {
			$datos['fecha'] = date('Y-m-j');
			$this->cn()->agregar_dt_inscripcion_colono($datos);

		}
	}

	
	//-----------------------------------------------------------------------------------
	//---- frm_telefonos_contacto -------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_telefonos_contacto(mupum_ei_formulario_ml $form_ml)
	{
		return $this->cn()->get_dt_telefono_inscripcion_colono();
	}

	function evt__frm_telefonos_contacto__modificacion($datos)
	{
		$this->cn()->procesar_dt_telefono_inscripcion_colono($datos);
	}

	function enviar_correo_constancia_inscripcion($datos)
	{
		$socio = $datos['titular'];
	    $colono = $datos['colono'];
	    $monto = $datos['monto'];
	    $monto_inscripcion = $datos['monto_inscripcion'];
	    $porcentaje = $datos['porcentaje_inscripcion'];
	    $fecha_inicio = $datos['fecha_inicio'];
	    $fecha_fin = $datos['fecha_fin'];
	    $domicilio = $datos['domicilio'];
	    $concentracion = $datos['concentracion'];
	    $salida = $datos['salida'];
	    $llegada = $datos['llegada'];
	    $finalizacion = $datos['finalizacion'];
	    $colonia = $datos['anio'];
	    
	    	    //Armo el mail nuevo &oacute;
	    $asunto = "Constancia de Inscripcion a Colonia ";
	    
		$cuerpo_mail = "Por medio del presente se deja Constancia de la Inscripcion a Colonia.<br/> ".
				"Los datos de la inscripcion son:<br/>".
				"Titular: ".$socio. "<br/>".
				"Colono: ".$colono. "<br/>".
				"Colonia: ". $colonia. "<br/>".
				"Monto Colonia: $". $monto. "<br/>".
				"Monto inscripcion: $". $monto_inscripcion. " es el : ". $porcentaje."% del monto de colonia.<br/>".
				"<b>IMPORTANTE : Esta inscripcion se hara efectiva cuando se concrete el pago. Al momento de concretar la inscripcion, </br>
				se requerirá de manera obligatoria el certificado medico de cada niño. </br>
				Para abonar la inscripcion debera acercarse a las instalaciones de la mutual ubicada en: <br/ >
				Santa Catalina 2378 -  Posadas - Misiones</b> <br/>".
				"La colonia da inicio el día:  ".$fecha_inicio." y finaliza el día ".$fecha_fin.".<br/>
				Horarios programados de salida y llegada <br/>
				Concentración: en ". $domicilio." a partir de las " .$concentracion." hs <br/>
				Salida: en ". $domicilio." a partir de las ".$salida." hs <br/>
				Llegada: en ". $domicilio." a partir de las ".$llegada." hs <br/>
				Finalización de la colonia/regreso: en ". $domicilio." a las ".$finalizacion." hs del dia ".$fecha_fin."<br/>".
				
				"<p>No responda este correo, fue generado por sistema. </p>";

        try 
        {
            $mail = new toba_mail($datos['correo'], $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
            $mail->set_html(true);
            $cc[] = trim('escalantegc@gmail.com');
            $mail->set_cc($cc);
            $mail->enviar();
        } catch (toba_error $error) {
            $chupo = $error->get_mensaje_log();
            toba::notificacion()->agregar($chupo, 'info');
        }
	}

	function enviar_correo_baja_inscripcion($datos)
	{
		$socio = $datos['titular'];
	    $colono = $datos['colono'];
	    $monto = $datos['monto'];
	    $monto_inscripcion = $datos['monto_inscripcion'];
	    $porcentaje = $datos['porcentaje_inscripcion'];
	    $fecha_inicio = $datos['fecha_inicio'];
	    $fecha_fin = $datos['fecha_fin'];
	    $domicilio = $datos['domicilio'];
	    $concentracion = $datos['concentracion'];
	    $salida = $datos['salida'];
	    $llegada = $datos['llegada'];
	    $finalizacion = $datos['finalizacion'];
	    $colonia = $datos['anio'];
	    $fecha_baja = $datos['fecha_baja'];

	    //Armo el mail nuevo &oacute;
	    $asunto = "Constancia de Baja Inscripcion a Colonia ";
	    
		$cuerpo_mail = "Por medio del presente se deja Constancia de la Baja de Inscripcion a Colonia.<br/> ".
				"Los datos de la baja de inscripcion son:<br/>".
				"Socio Titular: ".$socio. "<br/>".
				"Colono: ".$colono. "<br/>".
				"Colonia: ". $colonia. "<br/>".
				"Monto Colonia: $". $monto. "<br/>".
				"Monto inscripcion: $". $monto_inscripcion. " es el : ". $porcentaje."% del monto de colonia.<br/>".
				"Fecha Baja: ". $fecha_baja. ".<br/>".
				"<b>IMPORTANTE : Esta inscripcion fue dada de baja del sistema, en el caso de que se quiera inscribir nuevamente al mismo colono, debe realizar el proceso de nuevo. </b> <br/>".
				
				
				"<p>No responda este correo, fue generado por sistema. </p>";

        try 
        {
            $mail = new toba_mail($datos['correo'] , $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
            $mail->set_html(true);
            $cc[] = trim('escalantegc@gmail.com');
            $mail->set_cc($cc);
            $mail->enviar();
        } catch (toba_error $error) {
            $chupo = $error->get_mensaje_log();
            toba::notificacion()->agregar($chupo, 'info');
        }
	}

}
?>