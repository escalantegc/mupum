<?php
class ei_frm_ml_familia extends mupum_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__acargo__procesar = function(es_inicial, fila)
		{
			if(this.ef('acargo').ir_a_fila(fila).chequeado())
			{
				this.ef('archivo').ir_a_fila(fila).mostrar();	
			} else {
				this.ef('archivo').ir_a_fila(fila).ocultar();
			}
		}
		";
	}

}
?>