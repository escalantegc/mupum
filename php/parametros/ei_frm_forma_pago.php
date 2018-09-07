<?php
class ei_frm_forma_pago extends mupum_ei_formulario
{
	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		{$this->objeto_js}.ini = function () {
		
		
			this.ef('descripcion').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('descripcion');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}
		
		}
			
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__planilla__procesar = function(es_inicial)
		{
			if (this.ef('planilla').chequeado())
			{
				this.ef('efectivo').chequear(false);	
				this.ef('efectivo').ocultar();	
			} else {
				this.ef('efectivo').mostrar();	
			}
		}
		
		{$this->objeto_js}.evt__efectivo__procesar = function(es_inicial)
		{
			if (this.ef('efectivo').chequeado())
			{
				this.ef('planilla').chequear(false);	
				this.ef('planilla').ocultar();	
			} else {
				this.ef('planilla').mostrar();	
			}
		}
		";
	}

}
?>