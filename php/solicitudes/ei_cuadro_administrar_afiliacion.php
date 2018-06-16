<?php
class ei_cuadro_administrar_afiliacion extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__formulario($evento, $fila)
	{
		if ($this->datos[$fila]['solicitada'] != 'SI') 
		{
			$evento->anular();    
		}
	}

	function conf_evt__activar($evento, $fila)
	{
		if ($this->datos[$fila]['activa'] == 'SI') 
		{
			$evento->anular();    
		}
		if (($this->datos[$fila]['activa'] != 'SI') and ($this->datos[$fila]['solicitada'] !=' SI') )
		{
			$evento->anular();    
		}
	}

	function conf_evt__baja($evento, $fila)
	{
		if (($this->datos[$fila]['activa'] != 'SI') and ($this->datos[$fila]['solicitada'] != 'SI') )
		{
			$evento->anular();    
		}
	}

}
?>