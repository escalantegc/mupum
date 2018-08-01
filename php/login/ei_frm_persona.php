<?php
class ei_frm_persona extends mupum_ei_formulario
{
		//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
			{$this->objeto_js}.ini = function () {
			this.ef('apellido').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('apellido');
				var apellido = ef.get_estado().toUpperCase();
				var apellido_comprobado = apellido.match(/[a-z\s\'\u00d1]/gi);
				var cadena = apellido_comprobado.toString();
				while(cadena.indexOf(',') >= 0){
					cadena = cadena.replace(',','');
				}
				ef.set_estado(cadena);
			}
		
			this.ef('nombres').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('nombres');
				var nombre = ef.get_estado().toUpperCase();
				var nombre_comprobado = nombre.match(/[a-z\s\'\u00d1]/gi);
				var cadena = nombre_comprobado.toString();
				while(cadena.indexOf(',') >= 0){
					cadena = cadena.replace(',','');
				}
				ef.set_estado(cadena);
			}            
		
		}
		
			
		
		";
	}

}
?>