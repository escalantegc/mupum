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
		
		//--{$this->objeto_js}.evt__idafiliacion__procesar = function(es_inicial)
		//--{
			//--idf = this.ef('idafiliacion').get_estado();
			//--this.controlador.ajax('llevar_idf', idf, this, this.algo); 	
			
			
		//--}
		
		//--{$this->objeto_js}.algo = function(datos)
		//--{    
			
		//--}
		//---- Validacion de EFs -----------------------------------
		
		//--{$this->objeto_js}.evt__idafiliacion__validar = function()
		//--{
			//--this.controlador.buscar();
		            //--return true;
		//--}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__costo_grupo_familiar__procesar = function(es_inicial)
		{
			var costo = this.ef('costo_grupo_familiar').get_estado();
			if (costo != null)
			{
				this.ef('costo_grupo_familiar').desactivar();
				this.ef('total').set_estado(costo);
			}
			
		}
		
		{$this->objeto_js}.evt__costo_por_mayor__procesar = function(es_inicial)
		{
			if (this.ef('costo_por_mayor').get_estado()!=null)
			{
				this.ef('costo_por_mayor').desactivar();
			}
		}
		
	
		";
	}



}
?>