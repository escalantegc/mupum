<?php
class ei_frm_pileta extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idafiliacion__procesar = function(es_inicial)
		{
			//--idf = this.ef('idafiliacion').get_estado();
			//--this.controlador.ajax('llevar_idf', idf, this, this.algo); 	
		}
		
		{$this->objeto_js}.algo = function(datos)
		{    
			
		}
		//---- Validacion de EFs -----------------------------------
		
		//--{$this->objeto_js}.evt__idafiliacion__validar = function()
		//--{
			//--this.controlador.buscar();
            //--return true;
		//--}
		";
	}


}
?>