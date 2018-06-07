<?php
require_once('dao.php');
class ci_administrar_mis_reservas extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{

		$datos = dao::get_listado_reserva();
		
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__cancelar($seleccion)
	{
	}

}

?>