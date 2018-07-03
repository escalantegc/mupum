<?php
class ei_cuadro_usuario extends mupum_ei_cuadro
{
	
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__seleccion($evento, $fila)
	{
		if ($this->datos[$fila]['existe'] == 'SI') 
		{
			$evento->anular();    
		}
		if ($this->datos[$fila]['bloqueado'] != 'SI') 
		{
			$evento->anular();    
		}
	}

	function conf_evt__bloquear($evento, $fila)
	{
		if ($this->datos[$fila]['bloqueado'] == 'SI') 
		{
			$evento->anular();    
		}
		if ($this->datos[$fila]['existe'] != 'SI') 
		{
			$evento->anular();    
		}
		
	}

	function conf_evt__desbloquear($evento, $fila)
	{
		if ($this->datos[$fila]['existe'] == 'SI') 
		{
			$evento->anular();    
		}
		if ($this->datos[$fila]['bloqueado'] == 'SI') 
		{
			$evento->anular();    
		}

	}

	function conf_evt__crear($evento, $fila)
	{
		if ($this->datos[$fila]['existe'] != 'SI') 
		{
			$evento->anular();    
		}
	}

}
?>