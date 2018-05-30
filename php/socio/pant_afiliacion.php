<?php
class pant_afiliacion extends toba_ei_pantalla
{
	function extender_objeto_js()
	{

		echo "
			//----Eventos---------------------------------------------------------------------
		{$this->objeto_js}.ini = function()
		{
			this.controlador.ocultar_boton('procesar');
			this.controlador.ocultar_boton('cancelar');
		}
		";
	}

}
?>