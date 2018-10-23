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
		//---- Procesamiento de EFs --------------------------------
		{$this->objeto_js}.evt__idconvenio__procesar = function(es_inicial)
		{
			valor = this.ef('idconvenio').get_estado();
			if (valor!='nopar')
			{
				this.ef('total_max').mostrar();
			} else {
				this.ef('total_max').ocultar();
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
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__total__procesar = function(es_inicial)
		{
			total_max = this.ef('total_max').get_estado();
			total = this.ef('total').get_estado();
			if (total > total_max )
			{
				alert('El total del comsumo por socio no debe superar el permitido de: '+total_max);
				this.ef('total').resetear_estado();
			}
		}
		";
	}



}
?>