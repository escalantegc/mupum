<?php
class ci_listado_reservas extends mupum_ci
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
			$datos = dao::get_listado_reserva($this->s__where);
		}else{
			$datos = dao::get_listado_reserva();
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
	function get_estados_segun_categoria()
	{
		return dao::get_listado_estado('RESERVA');

	}		

	function get_estado_cancelada_segun_categoria()
	{
		return dao::get_listado_estado_cancelado_reserva('RESERVA');

	}	

	
	function get_motivos_segun_categoria($idafiliacion)
	{
		$where  = ' afiliacion.idafiliacion = '.$idafiliacion; 
		return dao::get_motivo_por_tipo_socio($where);
	}
}

?>