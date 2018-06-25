<?php
class ei_filtro_legajo extends mupum_ei_filtro
{
	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------		
		
		{$this->objeto_js}.evt__idpersona__procesar = function(es_inicial)
		{

			idpersona = this.ef('idpersona').get_estado();

			if (idpersona!='nopar')
			{	
				if (idpersona!='')
				{	
					this.mostrar_boton('filtrar');
					this.controlador.ajax('get_dato_filtro_idpersona', idpersona, this, this.actualizar_datos); 	
				} else {
					this.ocultar_boton('filtrar');
				}

			} else {
				this.ocultar_boton('filtrar');
			}
		}

		{$this->objeto_js}.actualizar_datos = function(datos)
		{                         
		}
		
		";
	}


}
?>