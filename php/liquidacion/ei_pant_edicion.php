<?php
class ei_pant_edicion extends toba_ei_pantalla
{

	function extender_objeto_js()
	{
		echo "
		//----Eventos---------------------------------------------------------------------
		{$this->objeto_js}.ini = function()
		{
			this.ocultar_boton('procesar');
			
		}
		";
	}
}
?>