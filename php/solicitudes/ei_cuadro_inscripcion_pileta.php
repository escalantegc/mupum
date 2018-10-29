<?php
class ei_cuadro_inscripcion_pileta extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['total_abonado'] > 0) 
		{
			$evento->anular();    
		}
	}

	

}
?>