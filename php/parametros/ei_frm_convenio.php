<?php
class ei_frm_convenio extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__permite_financiacion__procesar = function(es_inicial)
		{
			if (this.ef('permite_financiacion').chequeado())
			{
				this.ef('maximo_cuotas').mostrar();
				this.ef('permite_renovacion').mostrar();
			} else {
				this.ef('maximo_cuotas').resetear_estado();
				this.ef('permite_renovacion').resetear_estado();
				this.ef('maximo_cuotas').ocultar();
				this.ef('permite_renovacion').ocultar();
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		";
	}


}
?>