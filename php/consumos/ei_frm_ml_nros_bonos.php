<?php
class ei_frm_ml_nros_bonos extends mupum_ei_formulario_ml
{

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		
		{$this->objeto_js}.ini = function () 
		{
			//--tomo el id del htmlbuttonelement y seteo la visibilidad oculta
			document.getElementById(this.boton_deshacer().id).style.visibility = 'hidden';
			document.getElementById(this.boton_agregar().id).style.visibility = 'hidden';
			
			
		}

		{$this->objeto_js}.post_eliminar_fila = function(fila) 
		{
			var filas = this.filas()
			var cantidad = filas.length;
			this.controlador.dep('frm_edicion').ef('cantidad_bonos').set_estado(cantidad);				

		}
		";
	}

}
?>