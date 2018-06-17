<?php
class ei_cuadro_cancelar_afiliacion extends mupum_ei_cuadro
{
	function conf_evt__formulario($evento, $fila)
	{
		if ($this->datos[$fila]['solicita_cancelacion'] != 'SI') 
		{
			$evento->anular();    
		}
	}

	function conf_evt__activar($evento, $fila)
	{

		if (($this->datos[$fila]['activa'] != 'SI') and ($this->datos[$fila]['solicita_cancelacion'] !=' SI') )
		{
			$evento->anular();    
		}
	}

	function conf_evt__baja($evento, $fila)
	{
		if (($this->datos[$fila]['activa'] != 'SI') and ($this->datos[$fila]['solicita_cancelacion'] != 'SI') )
		{
			$evento->anular();    
		}
	}


}

?>