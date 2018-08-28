<?php
class ei_frm_configuracion_bolsita extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__inicio__procesar = function(es_inicial)
		{
			var inicio = this.ef('inicio').fecha();
			var fin = this.ef('fin').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(inicio > fin)
						{
							alert('La fecha inicio no puede ser mayor a la fecha fin');
							this.ef('fin').resetear_estado();
							this.ef('inicio').resetear_estado();
						} else {
						
							diff = fin - inicio;
							dias = diff/(1000*60*60*24) ;
							this.ef('cantidad_dias').set_estado(dias);
						}
					}
				}
			}	
		}
		
		{$this->objeto_js}.evt__fin__procesar = function(es_inicial)
		{
			var inicio = this.ef('inicio').fecha();
			var fin = this.ef('fin').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(fin < inicio)
						{
							alert('La fecha fin no puede ser menor a la fecha inicio');
							this.ef('fin').resetear_estado();
							this.ef('inicio').resetear_estado();
						} else {
						
							diff = fin - inicio;
							dias = diff/(1000*60*60*24) ;
							this.ef('cantidad_dias').set_estado(dias);
						}
					}
				}
			}	
		
		}
		";
	}

}

?>