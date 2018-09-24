<?php
require_once('dao.php');
class ci_listado_ingresos extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		return dao::get_listado_ingresos();
	}

}

?>