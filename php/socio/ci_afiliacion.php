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
		$interval = $datetime2->diff($datetime1);
		$meses = $interval->format('%m');
		$dias = $interval->format('%d');
		//ei_arbol('meses: '. $meses . ' dias: '.$dias);
		
		if ($meses == $configuracion['minimo_meses_afiliacion'])
		{
			if ($this->get_cn()->hay_cursor_dt_afiliacion($datos))
			{
				$this->s__persona = dao::get_listado_persona('persona.idpersona='.$afiliacion['idpersona']);
				$this->enviar_correo($this->s__persona[0]);
				$datos['solicita_cancelacion'] = 't';
				$this->get_cn()->set_dt_afiliacion($datos);

			} else {
				$this->get_cn()->agregar_dt_afiliacion($datos);
			}

		} else {

			toba::notificacion()->agregar("El periodo minimo de afiliacion es de: ".$configuracion['minimo_meses_afiliacion']. " no puede solicitar la baja antes.",'info');

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
        $cuerpo_mail = "<p>Estimado/a: </p>".trim($persona['apellido']) .", " .trim($persona['nombres'])."<br />
        				<p>Por medio del presente le informamos que la Solicitud de Baja de Afiliacion ha sido enviada correctamente con los siguentes datos: </p> 
        				<table>
						<tbody>
							<tr>
								<td>Documento: ".trim($persona['tipo_documento'])." - ".trim($persona['nro_documento'])."</td>
							</tr>
							<tr>
								<td>Legajo: ".trim($persona['legajo'])."</td>
							</tr>
							<tr>
								<td>Apellido y Nombres: ".trim($persona['apellido']).", ".trim($persona['nombres'])."</td>
							</tr>
							<tr>
								<td>Correo: ".trim($persona['correo'])."</td>
							</tr>
							<tr>
								<td>Telefono: ".trim($persona['tipo_telefono'])." - ".trim($persona['nro_telefono'])."</td>
							
							</tr>
							<tr>
								<td> Fecha Solicitud: ".trim($persona['fecha_solicitud'])."</td>
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


}
?>