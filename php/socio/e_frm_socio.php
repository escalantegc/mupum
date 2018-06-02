<?php
class e_frm_socio extends mupum_ei_formulario
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

			this.ef('calle').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('calle');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}
				
			this.ef('piso').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('piso');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}			
			this.ef('depto').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('depto');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}
			

		}
		
		{$this->objeto_js}.evt__fecha_nacimiento__procesar = function(es_inicial)
		{
			var fecha = new Date();

			if (this.ef('fecha_nacimiento').tiene_estado())
			{
				var edad = this.ef('fecha_nacimiento').calcular_edad(fecha)
				if (edad < 17)
				{
					alert('La persona no puede tener edad menor a 17.');
					this.ef('fecha_nacimiento').resetear_estado()
				} else {
					this.ef('edad').set_estado(edad);
				}
					
			} else {
				this.ef('edad').resetear_estado();
			}
		}
		";
	}

}
?>