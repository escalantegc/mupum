<?php
class ei_frm_administrar_reserva extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__nro_personas__procesar = function(es_inicial)
		{
			nro_personas = this.ef('nro_personas').get_estado();
			capacidad_permitida = this.ef('capacidad_permitida').get_estado();
			capacidad_maxima = this.ef('capacidad_maxima').get_estado()
			if (nro_personas!='')
			{
				if (nro_personas <= capacidad_maxima)
				{
					if (nro_personas > capacidad_permitida)
					{
						
						excedente = parseInt(nro_personas) - parseInt(capacidad_permitida);
						monto_ex = monto_persona_extra * excedente;
						
						this.ef('monto_excedente').set_estado(monto_ex);
						this.ef('excedente').set_estado(excedente);
		
						this.ef('monto').set_solo_lectura(true);
						this.ef('monto_excedente').set_solo_lectura(true);
						this.ef('monto_persona_extra').set_solo_lectura(true);
						
						total = parseInt(monto_ex)  + parseInt(monto_reserva);
						this.ef('monto').set_estado(total);
					} else {
						total =  parseInt(monto_reserva);
						this.ef('monto_excedente').resetear_estado();
						this.ef('excedente').resetear_estado();
						this.ef('monto').set_estado(total);
					}
				} else {
					alert('Esta excediendo la capacidad maxima de personas permitidas en la instalacion');
					this.ef('nro_personas').resetear_estado();
				}
				
			}
		}
		";
	}

}

?>