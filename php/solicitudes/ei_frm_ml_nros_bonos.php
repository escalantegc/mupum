<?php
class ei_frm_ml_nros_bonos extends mupum_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__persona_externa__procesar = function(es_inicial, fila)
		{
			if (this.ef('persona_externa').ir_a_fila(fila).chequeado())
			{
				this.ef('idafiliacion').ir_a_fila(fila).resetear_estado();
				this.ef('idafiliacion').ir_a_fila(fila).ocultar();
				this.ef('idpersona_externa').ir_a_fila(fila).mostrar();
			} else {
				
				this.ef('idafiliacion').ir_a_fila(fila).mostrar();
				this.ef('idpersona_externa').ir_a_fila(fila).resetear_estado();
				this.ef('idpersona_externa').ir_a_fila(fila).ocultar();
			}
		}
		";
	}

}

?>