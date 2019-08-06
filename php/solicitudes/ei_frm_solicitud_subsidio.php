<?php
class ei_frm_solicitud_subsidio extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Validacion de EFs -----------------------------------
		
			
		
		{$this->objeto_js}.evt__cantidad__validar = function()
		{
			cantidad = this.ef('cantidad').get_estado();
			limite = this.ef('limite').get_estado();
			if (cantidad >= limite)
			{
				this.ef('cantidad').set_error('Usted ya pidio la cantidad de veces permitidas para el tipo de subsidio.');
				return false;
			}
			return true;
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__monto__procesar = function(es_inicial)
		{
			this.ef('monto').desactivar();
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idtipo_subsidio__procesar = function(es_inicial)
		{
			var idtipo_subsidio = this.ef('idtipo_subsidio').get_estado();
		
			if ( idtipo_subsidio != '')
			{
				var nodo = this.ef('idtipo_subsidio').input();
				var indice = nodo.selectedIndex;
				var valor = '';
				
				if (indice != '')
				{
					valor = nodo.options[indice].text;
				}
				if (valor!='')
				{
					var pos = valor.indexOf('POR HIJO'); 
					
					
					if( pos == -1  )
					{
						this.ef('idpersona_familia').ocultar();
						this.ef('idpersona_familia').resetear_estado();
		
					} else {
						
						this.ef('idpersona_familia').mostrar();
					} 
				} else {
					
					this.ef('idpersona_familia').ocultar();
					this.ef('idpersona_familia').resetear_estado();
				}
			} else {
					
				this.ef('idpersona_familia').ocultar();
				this.ef('idpersona_familia').resetear_estado();
				
			} 
		}
		";
	}



}
?>