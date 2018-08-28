<?php
class ei_frm_nivel extends mupum_ei_formulario
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
		
		{$this->objeto_js}.evt__edad_minima__procesar = function(es_inicial)
		{
			minima = this.ef('edad_minima').get_estado();
			maxima = this.ef('edad_maxima').get_estado();
			if (minima!='')
			{
				if (maxima!='')
				{
					if (minima > maxima)
					{
						alert('La edad minima no puede ser mayor a la edad maxima');
						this.ef('edad_minima').resetear_estado();
						this.ef('edad_maxima').resetear_estado();
					}
				}
			}
		}
		
		{$this->objeto_js}.evt__edad_maxima__procesar = function(es_inicial)
		{
			minima = this.ef('edad_minima').get_estado();
			maxima = this.ef('edad_maxima').get_estado();
			if (minima!='')
			{
				if (maxima!='')
				{
					if (maxima < minima)
					{
						alert('La edad maxima no puede ser menor a la edad minima');
						this.ef('edad_minima').resetear_estado();
						this.ef('edad_maxima').resetear_estado();
					}
				}
			}
		}
		";
	}

}
?>