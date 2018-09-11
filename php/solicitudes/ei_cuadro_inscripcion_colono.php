<?php
class ei_cuadro_inscripcion_colono extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__seleccion($evento, $fila)
	{
		if ($this->datos[$fila]['tiene_plan'] == 'SI') 
		{
			$evento->anular();    
		}
	}	

	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['tiene_plan'] == 'SI') 
		{
			$evento->anular();    
		}
	}

}

?>