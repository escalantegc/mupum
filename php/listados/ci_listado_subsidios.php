<?php
class ci_listado_subsidios extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(ei_cuadro_administrar_solicitudes_subsidio $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_solicitudes_subsidio($this->s__where);
		}else{
			$datos = dao::get_listado_solicitudes_subsidio();
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
			$this->s__where = $filtro->get_sql_where();
			if (strstr($this->s__where, "pagado = 'null'"))
			{
				$this->s__where = str_replace("pagado = 'null'", "pagado is null", $this->s__where);
			}
		}
	}

	function evt__filtro__filtrar($datos)
	{
		if($datos['pagado']['valor']=='true')
		{
			$datos['pagado']['valor'] = 1;	
		}
		if($datos['pagado']['valor']=='false')
		{
			$datos['pagado']['valor'] = 0;	
		}

		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

}

?>