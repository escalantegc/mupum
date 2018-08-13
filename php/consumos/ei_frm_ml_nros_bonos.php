<?php
class ei_frm_ml_nros_bonos extends mupum_ei_formulario_ml
{

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		
		{$this->objeto_js}.ini = function () 
			{
				//--tomo el id del htmlbuttonelement y seteo la visibilidad oculta
				document.getElementById(this.boton_deshacer().id).style.visibility = 'hidden';
				document.getElementById(this.boton_agregar().id).style.visibility = 'hidden';
				
			}
		";
	}

}
?>