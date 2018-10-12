<?php
class ei_frm_bono_colaboracion extends mupum_ei_formulario
{
	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		{$this->objeto_js}.ini = function () {
		
		
			this.ef('descripcion').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('descripcion');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}
		}
			
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__persona_externa__procesar = function(es_inicial)
		{
			if (this.ef('persona_externa').chequeado())
			{
				this.ef('idafiliacion').resetear_estado();
				this.ef('idafiliacion').ocultar();
				this.ef('idpersona_externa').mostrar();
			} else {
				
				this.ef('idafiliacion').mostrar();
				this.ef('idpersona_externa').resetear_estado();
				this.ef('idpersona_externa').ocultar();
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__nro_inicio__procesar = function(es_inicial)
		{
			var inicio = this.ef('nro_inicio').get_estado();
			var fin = this.ef('nro_fin').get_estado();

			if (inicio !='')
			{
				if (fin !='')
				{
					if (inicio > fin)
					{
						alert('El numero de inicio no puede ser mayor al numero de fin');
						this.ef('nro_inicio').resetear_estado();
						this.ef('nro_fin').resetear_estado();
					}

				}				
			}

		}
		
		{$this->objeto_js}.evt__nro_fin__procesar = function(es_inicial)
		{
			var inicio = this.ef('nro_inicio').get_estado();
			var fin = this.ef('nro_fin').get_estado();

			if (inicio !='')
			{
				if (fin !='')
				{
					if (fin < inicio)
					{
						alert('El numero de fin no puede ser menor al numero de inicio');
						this.ef('nro_inicio').resetear_estado();
						this.ef('nro_fin').resetear_estado();
					}

				}				
			}
		}
		";
	}


}
?>