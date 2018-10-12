<?php
class cuadro_configurar_bono_colaboracion extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__seleccion($evento, $fila)
	{
		$fecha_sorteo = $this->datos[$fila]['fecha_sorteo'];
		$hoy = date("Y-m-d"); 

		if ($hoy >=$fecha_sorteo)
		{
			$evento->anular();   
		}
		
		
	}

}
?>