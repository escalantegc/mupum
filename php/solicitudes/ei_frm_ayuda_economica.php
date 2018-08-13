<?php
class ei_frm_ayuda_economica extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idconvenio__procesar = function(es_inicial)
		{	
			
			valor = this.ef('idconvenio').get_estado();
			if (valor!='nopar')
			{
			
				this.ef('total_max').mostrar();
				this.ef('cantidad_cuotas_max').mostrar();
		
		
			} else {
				this.ef('total_max').ocultar();
				this.ef('cantidad_cuotas_max').ocultar();
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__total__procesar = function(es_inicial)
		{
			total_max = this.ef('total_max').get_estado();
		
			total = this.ef('total').get_estado(); 
			if (total != null)
			{
				if (total_max != null)
				{
		
					if (total > total_max)
					{
		
						alert('No puede solicitar una ayuda economica con monto superior al permitido de: '+total_max);
						this.ef('total').resetear_estado();
					}
				}		
			}	
		
		}
		
		{$this->objeto_js}.evt__cantidad_cuotas__procesar = function(es_inicial)
		{
			cuotas_max = this.ef('cantidad_cuotas_max').get_estado();
			cuotas = this.ef('cantidad_cuotas').get_estado(); 
			if (cuotas != null)
			{
				if (cuotas_max != null)
				{
					if (cuotas > cuotas_max)
					{
						alert('La cantidad de cuotas no puede superar el maximo permitido de: '+cuotas_max);
						this.ef('cantidad_cuotas').resetear_estado();
					}
				}		
			}	
		
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__cantidad_cuotas_max__procesar = function(es_inicial)
		{
			cuotas_max = this.ef('cantidad_cuotas_max').get_estado();
			if (cuotas_max != null)
			{
				this.ef('cantidad_cuotas_max').desactivar();
				
			}		
				
		}
		
		{$this->objeto_js}.evt__total_max__procesar = function(es_inicial)
		{
			total_max = this.ef('total_max').get_estado();
			if (total_max != null)
			{
				this.ef('total_max').desactivar();
				
			}
		}
		";
	}



}
?>