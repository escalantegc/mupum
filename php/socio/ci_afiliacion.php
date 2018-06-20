<?php
require_once('dao.php');
class ci_afiliacion extends mupum_ci
{
	function get_cn()
	{
		return $this->controlador->cn();
	}
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver()
	{
		$this->get_cn()->resetear_cursor_dt_afiliacion();
		$this->set_pantalla('pant_inicial');
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		$persona = $this->get_cn()->get_dt_persona();
		
		if(isset($this->s__datos_filtro))
		{	
			$where = $this->s__where.' and afiliacion.idpersona ='.$persona['idpersona'];
			$datos = dao::get_listado_afiliacion($where);
		}else{
			$where = ' afiliacion.idpersona ='.$persona['idpersona'];
			$datos = dao::get_listado_afiliacion($where);
			
		}
		if (is_array($datos))
		{
			$cuadro->set_datos($datos);
		}
		
	}


	function evt__cuadro__cancelar($seleccion)
	{
		$this->get_cn()->set_cursor_dt_afiliacion($seleccion);
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
			$this->s__where=$filtro->get_sql_where();
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
		if ($this->get_cn()->hay_cursor_dt_afiliacion())
		{

			$datos = $this->get_cn()->get_dt_afiliacion();
			$datos['fecha_solicitud_cancelacion'] =  date("Y-m-d"); 
			
			
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		$afiliacion = $this->get_cn()->get_dt_afiliacion();
		$fecha_alta = $afiliacion['fecha_alta'];
		$fecha_hoy = date("Y-m-d"); 

		$configuracion = dao::get_configuracion();
		$datetime1 = date_create($fecha_alta);
		$datetime2 = date_create($fecha_hoy);
		$diferencia = $datetime1->diff($datetime2);

		$meses = ( $diferencia->y * 12 ) + $diferencia->m;
		/*$meses = $interval->format('%m');
		$dias = $interval->format('%d');*/
		//ei_arbol('meses: '. $meses );
		
		if ($meses >= $configuracion['minimo_meses_afiliacion'])
		{
			if ($this->get_cn()->hay_cursor_dt_afiliacion($datos))
			{
				$this->s__persona = dao::get_listado_persona('persona.idpersona='.$afiliacion['idpersona']);
				$this->s__persona[0]['fecha_solicitud_cancelacion'] =$datos['fecha_solicitud_cancelacion'] ;
				$this->enviar_correo($this->s__persona[0]);
				$datos['solicita_cancelacion'] = 't';
				$this->get_cn()->set_dt_afiliacion($datos);
				
			} else {
				$this->get_cn()->agregar_dt_afiliacion($datos);
			}

		} else {

			toba::notificacion()->agregar("No puede solicitar la baja con: ".$meses." meses de afiliacion. El periodo minimo de afiliacion es de: ".$configuracion['minimo_meses_afiliacion']. " meses.",'info');

		}

		
	}

	function get_estados_segun_categoria()
	{
		return dao::get_listado_estado('AFILIACION');

	}

	function enviar_correo($persona)
	{
        //Armo el mail nuevo &oacute;
        $asunto = "Constancia de Solicitud de Baja de afiliacion";
        $cuerpo_mail = "<p>Estimado/a: </p>".trim($persona['persona']) ."<br />
        				<p>Por medio del presente le informamos que la Solicitud de Baja de Afiliacion ha sido enviada correctamente con los siguentes datos: </p> 
        				<table>
						<tbody>
							<tr>
								<td>Documento: ".trim($persona['documento'])."</td>
							</tr>
							<tr>
								<td>Legajo: ".trim($persona['legajo'])."</td>
							</tr>
							<tr>
								<td>Apellido y Nombres: ".trim($persona['persona'])."</td>
							</tr>
							<tr>
								<td>Correo: ".trim($persona['correo'])."</td>
							</tr>
							
							<tr>
								<td> Fecha Solicitud: ".trim($persona['fecha_solicitud_cancelacion'])."</td>
							</tr>
						</tbody>
					</table>
        				<br />
           				Saludos ATTE .- </br >  MUPUM</br>".
          				"<p>No responda este correo, fue generado por sistema. </p>";
        try 
        {
                $mail = new toba_mail(trim($persona['correo']), $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
                $mail->set_html(true);
                /*$direcciones[]= 'administracion@mupum.unam.edu.ar';
                $direcciones[]= 'comision@mupum.unam.edu.ar';
                $mail->set_cc($direcciones);*/
                $mail->enviar();
        } catch (toba_error $error) {
                $chupo = $error->get_mensaje_log();
                toba::notificacion()->agregar($chupo, 'info');
        }
	}


	function evt__procesar()
	{
		try{
				$this->get_cn()->guardar_dr_socio();
				if(!toba::notificacion()->verificar_mensajes())
				{
					toba::notificacion()->agregar("La solicitud ha sido enviada correctamente",'info');	
				}
				
				
			} catch( toba_error_db $error){
			
			$mensaje_log= $error->get_mensaje_log();
		
			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');
				
			} 

		}
		$this->get_cn()->resetear_cursor_dt_afiliacion();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->get_cn()->resetear_cursor_dt_afiliacion();
		$this->set_pantalla('pant_inicial');
	}

}
?>