<?php
class ei_frm_gasto extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idconcepto__procesar = function(es_inicial)
		{
			idc = this.ef('idconcepto').get_estado();
		
			this.controlador.ajax('es_pago_proveedor', idc, this, this.mostrar_campos); 	

		}

		{$this->objeto_js}.mostrar_campos = function(datos)
		{    
			var sera = (datos['es']);
		   
			if (sera=='si')
			{
				this.ef('idcomercio').mostrar();
				
			} else {
				this.ef('idcomercio').ocultar();
			}            
		}
		";
	}

}
?>