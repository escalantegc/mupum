<?php
class ci_listado_bolsita_escolar extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_solicitudes_bolsitas($this->s__where);
		}else{
			$datos = dao::get_listado_solicitudes_bolsitas();
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
			if (strstr($this->s__where, "entregado = 'null'"))
			{
				$this->s__where = str_replace("entregado = 'null'", "entregado is null", $this->s__where);
			}
		}

	}

	function evt__filtro__filtrar($datos)
	{
		if($datos['entregado']['valor']=='true')
		{
			$datos['entregado']['valor'] = 1;	
		}
		if($datos['entregado']['valor']=='false')
		{
			$datos['entregado']['valor'] = 0;	
		}

		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

}

?>