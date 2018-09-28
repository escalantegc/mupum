<?php
class ei_frm_consumo_ticket extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__periodo__procesar = function(es_inicial)
		{
			periodo = this.ef('periodo').get_estado();
			if (periodo != '')
			{
				var periodo = periodo.match(/^(0[1-9]|1[0-2])\/([0-9]{4})$/gi);
				
				if (periodo != null)
				{
					this.ef('periodo').set_estado(periodo);
				} else {
					alert('Debe ingresar un periodo correcto');
					this.ef('periodo').seleccionar();
					this.ef('periodo').resetear_estado();
					
				}
				
				
			}
		}
		";
	}

}
?>