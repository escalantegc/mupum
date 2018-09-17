<?php
class ei_frm_comercio extends mupum_ei_formulario
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
		
			this.ef('direccion').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('direccion');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}
		
		}
			
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__tipo__procesar = function(es_inicial)
		{
			tipo = this.ef('tipo').get_estado();
			if (tipo == 'co' )
			{
				this.ef('nro_telefono').ocultar();
				this.ef('cuit').ocultar();
				this.ef('cbu').ocultar();
			} else {
				this.ef('nro_telefono').mostrar();
				this.ef('cuit').mostrar();
				this.ef('cbu').mostrar();
			}
		}
		";
	}

}
?>