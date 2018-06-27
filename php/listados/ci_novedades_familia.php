<?php
require_once('dao.php');
class ci_novedades_familia extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{

		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_novedades_familia($this->s__where);
			
		} else {
			$datos = dao::get_listado_novedades_familia();
		}
		$cuadro->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(mupum_ei_filtro $filtro)
	{
		if(isset($this->s__datos_filtro))
		{
			$filtro->set_datos($this->s__datos_filtro);
			$this->s__where=$filtro->get_sql_where();
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

}

?>