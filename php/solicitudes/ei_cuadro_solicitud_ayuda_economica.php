<?php
class ei_cuadro_solicitud_ayuda_economica extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__seleccion($evento, $fila)
	{		
		if ($this->datos[$fila]['pagado']!='ACEPTADA') 
		{
			$evento->anular();    
		}
	}

	function conf_evt__aceptar($evento, $fila)
	{
		if ($this->datos[$fila]['pagado']!='PENDIENTE') 
		{
			$evento->anular();    
		}	


	}

	function conf_evt__rechazar($evento, $fila)
	{
		if ($this->datos[$fila]['pagado']!='PENDIENTE') 
		{
			$evento->anular();    
		}
	}

}
?>