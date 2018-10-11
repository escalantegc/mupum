<?php
class ci_inscripcion_pileta extends mupum_ci
{
	protected $s__idpersona;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_pileta();
			/*$datos = $this->cn()->get_dt_inscripcion_pileta();
			$colonia = dao::get_datos_configuracion_colonia($datos['idconfiguracion_colonia']);
			//$inscripcion = dao::get_listado_inscripcion_pileta('inscripcion_pileta.idafiliacion = '.$datos['idafiliacion'] .' and inscripcion_pileta.idpersona_familia= '.$datos['idpersona_familia']);

			$socio = dao::get_datos_persona_afiliada($datos['idafiliacion']);
			$familiar = dao::get_datos_familiar($datos['idpersona_familia']);
			$inscripcion['titular'] = $socio[0]['persona'];
			$inscripcion['correo'] = $socio[0]['correo'];
		    $inscripcion['colono'] = $familiar[0]['familiar_titular'];

		    $inscripcion['monto'] = $datos['monto'];
		    $inscripcion['monto_inscripcion'] = $datos['monto_inscripcion'];
		    $inscripcion['porcentaje_inscripcion'] = $datos['porcentaje_inscripcion'];

		    $datos_correo = array_merge((array)$colonia[0], (array)$inscripcion); 
		  
		  	$this->enviar_correo_constancia_inscripcion($datos_correo);*/
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'inscripcion_pileta_idtemporada_pileta_idafiliacion_idx'))
			{
				toba::notificacion()->agregar("Su grupo familiar ya se encuentra inscripto, si desea agregar mas personas al grupo debe editar la inscripcion..",'info');
	
			} 
			
		}
		$this->cn()->resetear_dr_pileta();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_pileta();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$cantidad = dao::get_cantidad_temporada_pileta_vigente();
		if ($cantidad <=0)
		{
			toba::notificacion()->agregar("La temporada de pileta no ha comenzado.",'info');				
		} else {
			$this->set_pantalla('pant_edicion');
		}
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_inscripcion_pileta($this->s__where);
		}else{
			$datos = dao::get_listado_inscripcion_pileta();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_pileta($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_pileta($seleccion);
		$this->cn()->eliminar_dt_inscripcion_pileta($seleccion);
		try{
			

			$this->cn()->guardar_dr_pileta();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("No puede borrar al inscripcion del grupo familiar.",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_pileta();
		$this->set_pantalla('pant_inicial');
	}
	function evt__cuadro__ver($seleccion)
	{
		$this->cn()->cargar_dr_pileta($seleccion);
		$this->cn()->set_cursor_dt_inscripcion_pileta($seleccion);
		$this->set_pantalla('pant_ver');
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
		if ($this->cn()->hay_cursor_dt_inscripcion_pileta())
		{
			$datos = $this->cn()->get_dt_inscripcion_pileta();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_inscripcion_pileta())
		{
			$this->cn()->set_dt_inscripcion_pileta($datos);
		} else {
			$datos['fecha'] = date('Y-m-j');
			$this->cn()->agregar_dt_inscripcion_pileta($datos);

		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_grupo_familiar --------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_grupo_familiar(mupum_ei_formulario_ml $form_ml)
	{
		return $this->cn()->get_dt_detalle_inscripcion_pileta();

	}

	function evt__frm_ml_grupo_familiar__modificacion($datos)
	{
		$this->cn()->procesar_dt_detalle_inscripcion_pileta($datos);
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


	function ajax__llevar_idf($idf, toba_ajax_respuesta $respuesta)
	{
		$persona_afiliada = dao::get_datos_persona_afiliada($idf);
		$this->s__idpersona = $persona_afiliada[0]['idpersona'];
	}

	function get_familiares_menores_edad()
	{
		if (isset($this->s__idpersona))
		{
			
			return dao::get_listado_familia_menores_edad('persona.idpersona ='.$this->s__idpersona);	
		}
		
	}
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.buscar = function() {
				var parametro = this.dep('frm').ef('idafiliacion').get_estado();
				this.ajax('actualizar_hijos_menores', parametro, this, this.actualizar_datos);
				return false;
			}
	

			{$this->objeto_js}.actualizar_datos = function(datos)
			{
				var filas = this.dep('frm_ml_grupo_familiar').filas();
				for (id_fila in filas) {
					this.dep('frm_ml_grupo_familiar').ef('idpersona_familia').ir_a_fila(filas[id_fila]).set_opciones(datos);
				}
				this.dep('frm_ml_grupo_familiar').ef('idpersona_familia').ir_a_fila('__fila__').set_opciones(datos);
			}
		";
	}

	function ajax__actualizar_hijos_menores($parametro, toba_ajax_respuesta $respuesta)
	{

		$persona = dao::get_datos_persona_afiliada($parametro);	
		$familiares = dao::get_listado_familia_menores_edad('persona.idpersona ='.$persona[0]['idpersona']);
		//--ei_arbol($familiares);
		$result = array();		
		foreach($familiares as $familiar)
		{
			$result[$familiar['idpersona_familia']] =  $familiar['familiar_titular'];
		}
		
		$respuesta->set($result);
	}



	//-----------------------------------------------------------------------------------
	//---- frm_ml_grupo_familiar_ver ----------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_grupo_familiar_ver(eI_frm_ml_grupo_familiar $form_ml)
	{
				return $this->cn()->get_dt_detalle_inscripcion_pileta();

	}

	//-----------------------------------------------------------------------------------
	//---- frm_ver ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ver(ei_frm_pileta $form)
	{
		if ($this->cn()->hay_cursor_dt_inscripcion_pileta())
		{
			$datos = $this->cn()->get_dt_inscripcion_pileta();
			$form->set_datos($datos);
		
		}
	}

}
?>