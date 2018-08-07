<?php
class ei_frm_ml_cabecera extends mupum_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		{$this->objeto_js}.crear_fila_orig = {$this->objeto_js}.crear_fila; 
		{$this->objeto_js}.crear_fila       = function() {
			
			idconvenio = this.controlador.dep('frm_cabecera').ef('idconvenio').get_estado();
			idcomercio = this.controlador.dep('frm_cabecera').ef('idcomercio').get_estado();
			periodo = this.controlador.dep('frm_cabecera').ef('periodo').get_estado();
			

			id_fila = this.crear_fila_orig();

		
			this.ef('periodo').ir_a_fila(id_fila).set_estado(periodo);
			this.ef('idconvenio').ir_a_fila(id_fila).set_estado(idconvenio);
			this.ef('idcomercio').ir_a_fila(id_fila).set_estado(idcomercio);			

			this.ef('idconvenio').ir_a_fila(id_fila).ocultar();
			this.ef('idcomercio').ir_a_fila(id_fila).ocultar();
		}

		";
	}

}
?>