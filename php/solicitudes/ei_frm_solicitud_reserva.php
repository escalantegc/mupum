<?php
class ei_frm_solicitud_reserva extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		$fecha = $this->controlador()->get_fecha_seleccionada();
		echo "
		//---- Procesamiento de EFs --------------------------------
		var fecha = $fecha;
		{$this->objeto_js}.evt__fecha__procesar = function(es_inicial)
		{
			
			if (es_inicial) {
				if (fecha!= null) {
					this.ef('fecha').set_estado(fecha);
					
				}
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__nro_personas__procesar = function(es_inicial)
		{
			nro_personas = this.ef('nro_personas').get_estado();
			capacidad_permitida = this.ef('capacidad_permitida').get_estado();
			capacidad_maxima = this.ef('capacidad_maxima').get_estado();
			monto_persona_extra = this.ef('monto_persona_extra').get_estado();
			monto_reserva = this.ef('monto_temp').get_estado();
			this.ef('monto_temp').ocultar();
			
			if (nro_personas!='')
			{
				if (nro_personas <= capacidad_maxima)
				{
					if (nro_personas > capacidad_permitida)
					{
						
						excedente = nro_personas - capacidad_permitida;
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
		
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idmotivo_tipo_socio__procesar = function(es_inicial)
		{
		
			idmotivo = this.ef('idmotivo_tipo_socio').get_estado();
			if (idmotivo != '')
			{
				if (idmotivo != 'nopar')
				{
					this.controlador.ajax('traer_monto_senia', idmotivo, this, this.actualizar_datos); 	
				} else {
					this.ef('nro_personas').resetear_estado();
					this.ef('monto').resetear_estado();
				}
			}
		}
		{$this->objeto_js}.actualizar_datos = function(datos)
		{
			monto = (datos['monto_porcentaje']);

			var filas = this.controlador.dep('frm_detalle_pago').filas()
			 for (id_fila in filas) {
			      this.controlador.dep('frm_detalle_pago').ef('monto').ir_a_fila(filas[id_fila]).set_estado(monto);
			 }
			
		}
		";
	}



}
?>