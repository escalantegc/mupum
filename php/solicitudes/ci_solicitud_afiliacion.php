<?php
require_once('dao.php');
class ci_solicitud_afiliacion extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	protected $s__persona;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_solicitudes();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			$this->enviar_correo($this->s__persona[0]);
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La afiliacion esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_documento'))
			{
				toba::notificacion()->agregar("La afiliacion ya esta registrada.",'info');
				
			} 		

			if(strstr($mensaje_log,'idx_legajo'))
			{
				toba::notificacion()->agregar("El socio ya esta registrado.",'info');
				
			} 		

			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');
				
			} 
			
			
		}
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_solicitudes();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{	
			$datos = dao::get_listado_solicitud_afiliacion($this->s__where);
		}else{
			$datos = dao::get_listado_solicitud_afiliacion();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_solicitudes($seleccion);
		$this->cn()->set_cursor_dt_afiliacion($seleccion);
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
		if ($this->cn()->hay_cursor_dt_afiliacion())
		{
			$datos = $this->cn()->get_dt_afiliacion();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_afiliacion($datos))
		{
			$this->s__persona = dao::get_listado_persona($datos['idpersona']);
			$this->cn()->set_dt_afiliacion($datos);

		} else {
			$this->cn()->agregar_dt_afiliacion($datos);
		}
	}

	function get_estados_segun_categoria()
	{
		return dao::get_listado_estado('AFILIACION');

	}
	
	function enviar_correo($persona)
	{
		$user = $persona['nro_documento']; 
        $nombre = trim($persona['apellido']) .", " .trim($persona['nombres']);
        $clave= toba_usuario::generar_clave_aleatoria(8);
        $atributos['email'] = $persona['email'];

        //Armo el mail nuevo &oacute;
        $asunto = "Afiliacion Concretada";
        $cuerpo_mail = "<p>Estimado/a: </p>".trim($persona['apellido']) .", " .trim($persona['nombres'])."<br />
        				<p>Por medio del presente le informamos que usted ha sido Afiliado correctamente.</p> <br /><br />.
						<p>Los datos para poder ingresar al sistema son:.</p><br>".
						"<p>Usuario:</p>.".$user.".<br>".
						"<p>Clave:</p>.".$clave.".<br>".
						"<p>Se recomienda que cambie la clave en cuanto pueda ingresar al sistema</p><br>".
           				"Saludos ATTE .- </br >  MUPUM</br>".
          				"<p>No responda este correo, fue generado por sistema. </p>";


        toba::instancia()->agregar_usuario($user,$nombre,$clave,$atributos);
        $perfil = 'afiliado';
        toba::instancia()->vincular_usuario('mupum',$user,$perfil);

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

}

?>