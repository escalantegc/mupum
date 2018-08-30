<?php
class ei_frm_bono_colaboracion extends mupum_ei_formulario
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
		
		{$this->objeto_js}.evt__persona_externa__procesar = function(es_inicial)
		{
			if (this.ef('persona_externa').chequeado())
			{
				this.ef('idafiliacion').resetear_estado();
				this.ef('idafiliacion').ocultar();
				this.ef('idpersona_externa').mostrar();
			} else {
				
				this.ef('idafiliacion').mostrar();
				this.ef('idpersona_externa').resetear_estado();
				this.ef('idpersona_externa').ocultar();
			}
		}
		";
	}

}
?>