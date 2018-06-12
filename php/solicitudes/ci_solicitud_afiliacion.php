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
			$this->enviar_correo($this->s__persona[0]);
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
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
			if (strstr($mensaje_log,'apex_usuario_pk'))
			{
				toba::notificacion()->agregar('El usuario: '.$this->s__persona[0]['nro_documento'].' que quiere dar de alta ya existe', 'info');	
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
			$this->s__persona = dao::get_listado_persona('persona.idpersona='.$datos['idpersona']);
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
		//try{
			$user = $persona['nro_documento']; 
	        $nombre = trim($persona['persona']);
	        $clave= toba_usuario::generar_clave_aleatoria(8);
	        $atributos['email'] = $persona['correo'];

	        //Armo el mail nuevo &oacute;
	        $asunto = "Afiliacion Concretada";
	        $cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br />
	        				<p>Por medio del presente le informamos que usted ha sido Afiliado correctamente.</p> 
							<p>Los datos para poder ingresar al sistema son:</p>".
							"Usuario:".$user. "<br>".
							"Clave:".$clave.
							"<p>Se recomienda que cambie la clave en cuanto pueda ingresar al sistema.</p>".
	           				"Saludos ATTE .- MUPUM<".
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

	function vista_jasperreports(toba_vista_jasperreports $report)
	{
		//toma como id el indice de la consulta, va de 0 a n
		$idafiliacion = toba::memoria()->get_parametro('idafiliacion');

		//--leo los datos segun el filtro que tenga para que sepa los indice tal cuales esta en el cuadro
		if(isset($this->s__datos_filtro))
		{	
			$datos = dao::get_listado_solicitud_afiliacion($this->s__where);
		}else{
			$datos = dao::get_listado_solicitud_afiliacion();
		}

		$reporte ='formulario_afiliacion.jasper';
		$path = toba::proyecto()->get_path().'/exportaciones/'.$reporte;	

		$path_logo = toba::proyecto()->get_path().'/www/logo/logo.gif';	

		$report->set_path_reporte($path);
		//Parametro para el titulo
		$report->set_parametro('titulo','S','FORMULARIO DE AFILIACION ');
		//Parametros para el encabezado del titulo
		$report->set_parametro('logo','S',$path_logo);
		//Paramentro del filtro
	
		//
		$report->set_parametro('idafiliacion', 'E', $datos[$idafiliacion]['idafiliacion']);
		
		//Parametros para el usuario
		//$report->set_parametro('usuario','S',toba::usuario()->get_id());
		$report->set_nombre_archivo('formulario_afiliacion'.$idafiliacion.'.pdf');   	
		$db = toba::fuente('mupum')->get_db();
		$report->set_conexion($db);	
	}

	function extender_objeto_js()
    {
  
    	echo "
        {$this->dep('cuadro')->objeto_js}.evt__imprimir = function(params) {
            location.href = vinculador.get_url(null, null, 'vista_jasperreports', {'idafiliacion': params});
   
            return false;
        }
		";
        
    }

}

?>