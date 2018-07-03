<?php
class ci_cambiar_clave extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
	}

	function evt__frm__alta($datos)
	{
		$usuario = toba::usuario()->get_id();
		if (!(toba_usuario_basico::autenticar($usuario, $datos['clave_actual'])))
		{
		 	toba::notificacion()->agregar("La clave actual ingresada no es la correcta.");
			return;
		}   
		if ($datos['nueva_clave'] != $datos['repeticion_clave'])
		{
		 	$this->informar_msg("La contraseña nueva y la confirmacion deben ser iguales");
		} else {           
			toba_usuario::set_clave_usuario($datos['nueva_clave'] , $usuario);
			$this->pantalla()->set_descripcion('La clave fue actualizada correctamente.<br>');       
		}  
	}

	function evt__frm__cancelar()
	{
		toba::vinculador()->navegar_a('mupum', '2');
	}

}
?>