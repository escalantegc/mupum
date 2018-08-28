<?php
class ei_cuadro_solicitudes_subsidio extends mupum_ei_cuadro
{
	function conf_evt__seleccion($evento, $fila)
	{
		//-ei_arbol($this->datos);
		if ( $this->datos[$fila]['estado']!='PENDIENTE') 
		{
			$evento->anular();    
		}
	}

	function conf_evt__borrar($evento, $fila)
	{
		if ( $this->datos[$fila]['estado']!='PENDIENTE') 
		{
			$evento->anular();    
		}
	}
}

?>