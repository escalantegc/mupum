<?php
class ei_frm_cabecera_consumo_ticket_gral extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__total_max__procesar = function(es_inicial)
		{
			total_max = this.ef('total_max').get_estado();
			if (total_max != null)
			{
				this.ef('total_max').desactivar();
				
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idconvenio__procesar = function(es_inicial)
		{
			valor = this.ef('idconvenio').get_estado();
			if (valor!='nopar')
			{
				this.ef('total_max').mostrar();
			} else {
				this.ef('total_max').ocultar();
			}
		}
		";
	}


}
?>