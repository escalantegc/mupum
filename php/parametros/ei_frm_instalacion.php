<?php
class ei_frm_instalacion extends mupum_ei_formulario
{
	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		{$this->objeto_js}.ini = function () {
		

			this.ef('nombre').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('nombre');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}	

			this.ef('domicilio').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('domicilio');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}
		
			

		}
	
		";
	}
}

?>