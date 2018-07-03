<?php
class ei_cuadro_afiliacion extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------



	function conf_evt__cancelar($evento, $fila)
	{
		if ($this->datos[$fila]['activa'] != 'SI') 
		{
			$evento->anular();    
		}
				
		if ($this->datos[$fila]['solicita_cancelacion'] == 'SI') 
		{
			$evento->anular();    
		}

	}

	
	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['activa'] != 'SI') 
		{
			$evento->anular();    
		}
	}

}
?>