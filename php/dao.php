<?php
class dao 
{
	function get_listado_persona($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
						 nro_documento, 
						cuil, 
						legajo, 
						(apellido||', '||nombres) as persona, 
   					correo, 
   					cbu, 
   					fecha_nacimiento, 
   					idlocalidad, 
   					calle, altura, 
   					piso, 
   					depto, 
   					idestado_civil
  				FROM public.persona
  				inner join tipo_documento using(idtipo_documento)
  				where
  					$where 
  				order by
  					descripcion";
  		return consultar_fuente($sql);
	}




	function get_listado_tipo_socio($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idtipo_socio, 
						        descripcion,
                    titular
  				FROM public.tipo_socio
  				where
  					$where
  				order by
  					descripcion";
  		return consultar_fuente($sql);
	}

	function get_listado_tipo_documento($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idtipo_documento, 
						sigla, 
						descripcion
  				FROM 
  					public.tipo_documento
  				where
  					$where
  				order by
  					sigla,
  					descripcion";
  		return consultar_fuente($sql);
	}

	function get_localidades_combo_editable($filtro = null)
	{
		if (! isset($filtro) || trim($filtro)=='')
		{
			return array();
		}
		$filtro = quote("%{$filtro}%");

		$sql = "SELECT 	localidad.idlocalidad, 
						localidad.descripcion ||' - '||provincia.descripcion ||' - '|| pais.descripcion as localidad
				  FROM 
				  	public.localidad
				  inner join provincia using (idprovincia)
				  inner join pais using (idpais)
				 WHERE 
				 	(localidad.descripcion ||' - '||provincia.descripcion ||' - '|| pais.descripcion) ilike $filtro limit 20 ";
		return consultar_fuente($sql);

	}	

	function get_descripcion_localidad($idlocalidad = null)
	{
	

		$sql = "SELECT 	localidad.idlocalidad, 
						localidad.descripcion ||' - '||provincia.descripcion ||' - '|| pais.descripcion as localidad
				  FROM 
				  	public.localidad
				  inner join provincia using (idprovincia)
				  inner join pais using (idpais)
				 WHERE 
				 	localidad.idlocalidad =  $idlocalidad";
		$res = consultar_fuente($sql);
		if (isset($res[0]['localidad']))
		{
			return $res[0]['localidad'];
		}

	}

	function get_listado_estado_civil($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idestado_civil, 
						        descripcion
  				FROM 
  					public.estado_civil	
  				WHERE
  					$where
  				order by
  					descripcion";
  		return consultar_fuente($sql);	
	}

	function get_tipo_telefono($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idtipo_telefono, 
						descripcion
  				FROM 
  					public.tipo_telefono
  				WHERE
  					$where
  				order by
  					descripcion";
  		return consultar_fuente($sql);	
	}

	
	function get_listado_nivel_estudio($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}

		$sql = "SELECT idnivel_estudio, 
						descripcion, 
						nivel,
						orden
  				FROM 
  				public.nivel_estudio
  				WHERE
  					$where
  				order by orden asc";
  		return consultar_fuente($sql);		
	}

	  
  function get_listado_pais($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT 	idpais, 
  						descripcion
  				FROM public.pais
  				WHERE
  					$where
  				order by 
  					descripcion";
  		return consultar_fuente($sql);
  	}  

  function get_listado_provincia($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT 	idprovincia, 
  						pais.descripcion as pais,
  						provincia.descripcion
  				FROM 
  					public.provincia
  				inner join pais using (idpais)
   				WHERE
  					$where
  				order by 
  					provincia.descripcion";
  		return consultar_fuente($sql);
  	} 

  function get_listado_localidad($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT 	localidad.idprovincia, 
  						localidad.idlocalidad,
  						pais.descripcion as pais,
  						provincia.descripcion as provincia,
  						localidad.descripcion 
  				FROM 
  					public.localidad
  				inner join provincia using (idprovincia)
  				inner join pais using (idpais)
   				WHERE
  					$where
  				order by 
  					localidad.descripcion";
  		return consultar_fuente($sql);
  	}

    function get_pais_localidad($idlocalidad)
  	{
  		$sql = "SELECT idpais
				FROM 
					public.localidad
				 inner join provincia using (idprovincia)
				   where idlocalidad =$idlocalidad";

		return consultar_fuente($sql);
  	}
  	
    function get_pais_provincia($idprovincia)
  	{
  		$sql = "SELECT idpais
				FROM 
					public.provincia
				   where idprovincia =$idprovincia";

		return consultar_fuente($sql);
  	}


    function get_listado_provincia_cascada($idpais = null)
    {

    	$sql = "SELECT 	idprovincia, 
    					provincia.descripcion
    			FROM 
    				public.provincia
    				WHERE
    				provincia.idpais = $idpais 
    			order by
    				descripcion";
    	return consultar_fuente($sql);
    }  
  
  	function get_nombre_localidad($idlocalidad = null)
  	{
  		$sql = "SELECT  descripcion
  				FROM 
  					public.localidad
  				WHERE
  					idlocalidad = $idlocalidad;";
  		return consultar_fuente($sql);
  	}

  	function get_configuracion()
  	{
  		$sql ="	SELECT *
 				 FROM 
 				 	public.configuracion;";
 		return consultar_fuente($sql);
  	
  	}

  	
  	
	function get_descripcion_persona_popup($idpersona)
	{
		$sql = "SELECT  
					nombres||', '|| apellido as persona
				FROM 
					persona
				where 
					idpersona=$idpersona ";
		$resultado = consultar_fuente($sql);
		if ( isset($resultado[0]) ) {
			return $resultado[0]['persona'];
		}
	}

	function get_listado_parentesco($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT 	idparentesco, 
  						descripcion, 
  						bolsita_escolar
  				FROM public.parentesco
   				WHERE
  					$where
  				order by 
  					parentesco.descripcion";
  		return consultar_fuente($sql);
  }

  function get_listado_tipo_telefono($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT idtipo_telefono, 
  						descripcion
 				 FROM 
 				 	public.tipo_telefono
   				WHERE
  					$where
  				order by 
  					tipo_telefono.descripcion";
  		return consultar_fuente($sql);
	}

  function get_listado_estado($categoria_estado = null)
  {
    $categoria_estado = quote("%{$categoria_estado}%");
    $sql = "SELECT  estado.idestado, 
            estado.descripcion

        FROM 
          public.estado
        inner join categoria_estado using (idcategoria_estado)
        WHERE
          categoria_estado.descripcion ilike $categoria_estado ";
    return consultar_fuente($sql);

  }
  
	function get_listado_estado_afiliacion($estado = null)
	{
		$estado = quote("%{$estado}%");
		$sql = "SELECT 	estado.idestado, 
						estado.descripcion

				FROM 
					public.estado
				inner join categoria_estado using (idcategoria_estado)
				WHERE
					categoria_estado.descripcion ilike '%afiliacion%' and
          estado.descripcion ilike $estado";
		return consultar_fuente($sql);

	}

  function get_listado_afiliacion($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  afiliacion.idafiliacion, 
                    afiliacion.idpersona, 
                    tipo_socio.descripcion  as tipo, 
                    estado.descripcion as estado, 
                    fecha_solicitud, 
                    fecha_alta, 
                    fecha_baja, 
                    afiliacion.activa
            FROM
                public.afiliacion
            inner join estado using (idestado)
            inner join tipo_socio using (idtipo_socio)
            WHERE
              $where
            order by 
              afiliacion.fecha_alta";
    return consultar_fuente($sql);
  }  

  function get_listado_solicitud_afiliacion($where = null)
  {
    if (!isset($where))
    {
    	$where = '1 = 1';
    }
  	$sql = "SELECT 	afiliacion.idafiliacion, 
            				afiliacion.idpersona, 
            				tipo_socio.descripcion  as tipo, 
            				estado.descripcion as estado, 
            				fecha_solicitud, 
            				fecha_alta, 
            				fecha_baja, 
            				afiliacion.activa,
                    persona.apellido||', '|| persona.nombres as persona,
                    tipo_documento.sigla ||'-'|| persona.nro_documento as documento
      		  FROM
      		  		public.persona
      		 
      		  inner join afiliacion using (idpersona)
            inner join tipo_documento using(idtipo_documento)
            inner join estado using (idestado)
            inner join tipo_socio using (idtipo_socio)
      		  WHERE
      				$where
      			order by 
      				afiliacion.fecha_solicitud desc";
  	return consultar_fuente($sql);
  }

  function get_listado_categoria_estado($where = null)
  {
  	if (!isset($where))
  	{
  		$where = '1 = 1';
  	}
  		$sql = "SELECT idcategoria_estado, 
  						descripcion
  				FROM 
  					public.categoria_estado
   				WHERE
  					$where
  				order by 
  					categoria_estado.descripcion";
  		return consultar_fuente($sql);
  	}

  function get_listado_estados($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
        $sql = "SELECT  estado.idestado, 
                        estado.descripcion,
                        estado.solicitada,
                        estado.activa,
                        estado.baja,
                        categoria_estado.descripcion as categoria
            FROM 
              public.estado
          inner join categoria_estado using (idcategoria_estado)
          where
            $where
          order by 
            categoria,estado.idestado";
      return consultar_fuente($sql);
  }
  
  function get_tipo_socio_titular()
	{
    		$sql = "SELECT  idtipo_socio, 
                        descripcion, 
                        titular
                FROM 
                  public.tipo_socio
                where 
                  titular = true";
  		return consultar_fuente($sql);
  }

  function cargar_calendario_reserva () {
    
    $sql = "SELECT  idsolicitud_reserva, 
                    idafiliacion, 
                    fecha, 
                    idinstalacion, 
                    estado.idestado, 
                    idmotivo, 
                    nro_personas,
                    'RESERVA '||estado.descripcion as contenido, 
                    fecha as dia
            FROM 
              public.solicitud_reserva
              inner join estado using (idestado)";

    $dias = consultar_fuente($sql);
    $datos = null;
    foreach ($dias as $dia) {
      $datos[$dia['dia']] = array('dia'=> $dia['dia'], 'contenido'=> $dia['contenido'],'idsolicitud_reserva'=> $dia['idsolicitud_reserva']) ;
    } 
    return $datos;
  }

  function get_personas_afiliadas()
  {
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                  persona.apellido||', '|| persona.nombres as persona
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            where 
              activa = true";

    return consultar_fuente($sql);

  }

  function get_listado_instalacion ($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql ="SELECT   idinstalacion, 
                      nombre, 
                      cantidad_maxima_personas,
                      domicilio
              FROM 
                public.instalacion;";
      return consultar_fuente($sql);
  }

  function get_listado_motivos($categoria_motivo = null)
  {
    $categoria_motivo = quote("%{$categoria_motivo}%");
    $sql = "SELECT  motivo.idmotivo, 
                    motivo.descripcion  
            FROM 
                public.motivo
            inner join categoria_motivo using(idcategoria_motivo)
            where 
                categoria_motivo.descripcion ilike $categoria_motivo";
     return consultar_fuente($sql);
  }  

  function get_listado_motivo($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
    $sql = "SELECT  motivo.idmotivo, 
                    motivo.descripcion,
                    categoria_motivo.descripcion as categoria
            FROM 
                public.motivo
            inner join categoria_motivo using(idcategoria_motivo)
            where 
                $where
            order by
                descripcion";
     return consultar_fuente($sql);
  }

  function get_listado_reserva($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql="SELECT  solicitud_reserva.idsolicitud_reserva, 
                    persona.apellido ||', '|| persona.nombres as persona,
                    fecha, 
                    instalacion.nombre as instalacion, 
                    estado.descripcion as estado, 
                    motivo.descripcion as motivo, 
                    nro_personas
            FROM 
                public.solicitud_reserva
            inner join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join estado on estado.idestado = solicitud_reserva.idestado
            inner join motivo using(idmotivo)
            inner join instalacion using(idinstalacion)
            where
                $where
            order by fecha desc";
      return consultar_fuente($sql);

  }

  function get_listado_forma_pago($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql = "SELECT  idforma_pago, 
                      descripcion
              FROM 
                  public.forma_pago 
              cargar_calendario_reserva
              where
                $where
              order by
                  descripcion";
      return consultar_fuente($sql);
  }

  function get_listado_categoria_motivo($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql = "SELECT  idcategoria_motivo, 
                      descripcion
              FROM 
                  public.categoria_motivo
              where
                $where
                order by 
                  descripcion";
      return consultar_fuente($sql);
  }

  function get_descripcion_tipo_telefono($idtipo_telefono = null)
  {
    $sql = "SELECT  descripcion
            FROM 
              public.tipo_telefono
            where 
             idtipo_telefono=$idtipo_telefono";
    $res = consultar_fuente($sql);
    if (isset($res[0]['descripcion']))
    {
      return $res[0]['descripcion'] ;
    }

  }  

  function get_descripcion_tipo_documento($idtipo_documento = null)
  {
    $sql = "SELECT  sigla
            FROM 
              public.tipo_documento
            where 
             idtipo_documento = $idtipo_documento";
    $res = consultar_fuente($sql);
    if (isset($res[0]['sigla']))
    {
      return $res[0]['sigla'] ;
    }

  }
}
?>