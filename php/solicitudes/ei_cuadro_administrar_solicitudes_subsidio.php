<?php
class ei_cuadro_administrar_solicitudes_subsidio extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__aceptar($evento, $fila)
	{
		if ( $this->datos[$fila]['estado']!='PENDIENTE') 
		{
			$evento->anular();    
		}
	}

	function conf_evt__rechazar($evento, $fila)
	{
		if ( $this->datos[$fila]['estado']!='PENDIENTE') 
		{
			$evento->anular();    
		}
	}



}

?>