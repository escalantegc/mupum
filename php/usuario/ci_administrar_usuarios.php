<?php
require_once('dao.php');
class ci_administrar_usuarios extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	protected $s__user;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_usuario();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			

			$mensaje_log= $error->get_mensaje_log();
			
			toba::notificacion()->agregar($mensaje_log,'info');
			 
			
		}
		$this->cn()->resetear_dr_usuario();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_usuario();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_socios_libre($this->s__where);
			$usuarios = array();
			foreach ($datos  as $dato) 
			{
				$filtro['usuario'] = trim($dato['usuario']);
				$this->cn()->cargar_dt_usuario($filtro);
				$resultado = $this->cn()->existe_dt_usuario($filtro);
				$dato['existe'] = 0;
				if ($resultado == 'existe')
				{
					$dato['existe'] = 1;
					if (toba::instancia()->es_usuario_bloqueado($filtro['usuario']))
	    			{
	    				$dato['bloqueado'] = 1;
	    			} else {
	    				$dato['bloqueado'] = 0;
	    			}
				} else {
					$dato['bloqueado'] = 0;
				}
				$usuarios[] = $dato;
				$this->cn()->resetear_dt_usuario();

			}

			$cuadro->set_datos($usuarios);
		}
		
	}

	function evt__cuadro__seleccion($seleccion)
	{

		$this->cn()->cargar_dr_usuario($seleccion);
		$this->cn()->set_cursor_dt_usuario($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__bloquear($seleccion)
	{
		toba::instancia()->bloquear_usuario($this->s__user);
	}

	function evt__cuadro__desbloquear($seleccion)
	{
		toba::instancia()->desbloquear_usuario($this->s__user);
	}
	
	function evt__cuadro__crear($seleccion)
	{
		$this->s__user = $seleccion['usuario'];
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
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_usuario())
		{
			$usuario = $this->cn()->get_dt_usuario();
			$form->set_datos($usuario);
		} else {
			$usuario['usuario'] = $this->s__user;
			$form->set_datos($usuario);
		}
	

	}

	function evt__frm__modificacion($datos)
	{
		$usuario = quote("{$datos['usuario']}");
		if ($this->cn()->hay_cursor_dt_usuario())
		{
			if($datos['cambiar_clave']==1)
			{
				
				$persona = dao::get_listado_persona('persona.nro_documento='.$usuario);
				$this->enviar_correo_usuario($persona[0]);
				
			}
		} else {

			$datos['clave'] = toba_usuario::generar_clave_aleatoria(8);
			
			if($datos['cambiar_clave']==1)
			{
				
				
				$persona = dao::get_listado_persona('persona.nro_documento='.$usuario);
				$persona[0]['clave'] = $datos['clave'];
				$datos['nombre'] = $persona[0]['persona'];
				$datos['email'] = $persona[0]['correo'];
				$this->enviar_correo_usuario($persona[0]);
				
			}
			$this->cn()->agregar_dt_usuario($datos);
			
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_perfiles --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_perfiles(mupum_ei_formulario_ml $form_ml)
	{
		if ($this->cn()->hay_cursor_dt_usuario())
		{
			$datos = $this->cn()->get_dt_usuario_proyecto();
			$form_ml->set_datos($datos);
		}
	}

	function evt__frm_ml_perfiles__modificacion($datos)
	{
		$this->cn()->procesar_dt_usuario_proyecto($datos);
	}

	function enviar_correo_usuario($persona)
	{
		//try{
			$user = $persona['nro_documento']; 
	        $nombre = trim($persona['persona']);
	        $atributos['email'] = $persona['correo'];
	        $clave = $persona['clave'];
	        

	        //Armo el mail nuevo &oacute;
	        $asunto = "Datos de Acceso";
	        
			$cuerpo_mail = "<p>Estimado/a: </p>".trim($nombre)."<br>".
    				"<p>Por medio del presente le informamos que los datos para poder ingresar al sistema son:</p> ".
					"Usuario: ".$user. "<br>".
					"Clave: ".$clave. "<br>".
					"<p>Debe respetar mayusculas y minisculas en la clave.</p>".
					"<p>Se recomienda que cambie la clave en cuanto pueda ingresar al sistema.</p>".
       				"<p>Saludos ATTE .- MUPUM</p>".
      				"<p>No responda este correo, fue generado por sistema. </p>";
        try 
        {
                $mail = new toba_mail(trim($persona['correo']), $asunto, $cuerpo_mail,'info@mupum.unam.edu.ar');
                toba::notificacion()->agregar("Los datos de acceso se han enviado correctamente",'info');
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