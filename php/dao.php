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
    $sql = "SELECT  estado.idestado, 
            estado.descripcion

        FROM 
          public.estado
        inner join categoria_estado using (idcategoria_estado)
        WHERE
          categoria_estado.descripcion ilike '%afiliacion%' and
          estado.descripcion ilike $estado";
    return consultar_fuente($sql);

  }	

  function get_listado_estado_reserva($estado = null)
  {
    $estado = quote("%{$estado}%");
    $sql = "SELECT  estado.idestado, 
            estado.descripcion


        FROM 
          public.estado
        inner join categoria_estado using (idcategoria_estado)
        WHERE
          categoria_estado.descripcion ilike '%reserva%' and
          estado.descripcion ilike $estado";
    return consultar_fuente($sql);

  }
  function get_listado_estado_cancelado_reserva()
	{

		$sql = "SELECT 	estado.idestado, 
						estado.descripcion


				FROM 
					public.estado
				inner join categoria_estado using (idcategoria_estado)
				WHERE
					categoria_estado.descripcion ilike '%reserva%' and
          estado.cancelada = true";
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
                    afiliacion.activa,
                    afiliacion.solicitada,
                    solicita_cancelacion,
                    fecha_solicitud_cancelacion
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
    $sql = "SELECT  afiliacion.idafiliacion, 
                    afiliacion.idpersona, 
                    tipo_socio.descripcion  as tipo, 
                    estado.descripcion as estado, 
                    fecha_solicitud, 
                    fecha_alta, 
                    fecha_baja, 
                    afiliacion.activa,
                    persona.apellido||', '|| persona.nombres as persona,
                    tipo_documento.sigla ||'-'|| persona.nro_documento as documento,
                    afiliacion.solicitada
            FROM
                public.persona
           
            inner join afiliacion using (idpersona)
            inner join tipo_documento using(idtipo_documento)
            left outer join estado using (idestado)
            inner join tipo_socio using (idtipo_socio)
            WHERE
             
              $where
            order by 
              afiliacion.fecha_solicitud desc";
    return consultar_fuente($sql);
  } 

  function get_listado_cancelacion_afiliacion($where = null)
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
                    tipo_documento.sigla ||'-'|| persona.nro_documento as documento,
                    afiliacion.solicitada,
                    fecha_solicitud_cancelacion,
                    solicita_cancelacion
      		  FROM
      		  		public.persona
      		 
      		  inner join afiliacion using (idpersona)
            inner join tipo_documento using(idtipo_documento)
            left outer join estado using (idestado)
            inner join tipo_socio using (idtipo_socio)
      		  WHERE
      				 solicita_cancelacion = true and
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
                        estado.confirmada,
                        estado.cancelada,
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
                    instalacion.idinstalacion, 
                    instalacion.nombre as instalacion, 
                    estado.idestado, 
                    idmotivo, 
                    nro_personas,
                    
                    (select traer_instalaciones_ocupadas(fecha)) as contenido,
                    fecha as dia
            FROM 
              public.solicitud_reserva
              inner join estado using (idestado)
              inner join instalacion using (idinstalacion)
            where estado.cancelada = false";

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
                public.instalacion 
              where 
                $where";
      return consultar_fuente($sql);
  }  

  function get_listado_instalacion_disponible ($fecha = null)
  {
      $solicitudes = consultar_fuente("SELECT idinstalacion  FROM public.solicitud_reserva  inner join estado on estado.idestado = solicitud_reserva.idestado where fecha = $fecha and estado.cancelada =false");
      
      $where = null;
      foreach ($solicitudes as $solicitud) 
      {
        $where.= ' instalacion.idinstalacion != '.$solicitud['idinstalacion'] .' and';
      }
     
      
      $sql = '';
      if (isset($where))
      {
       $where = substr($where, 0, strlen($where)-4);
       $sql ="  SELECT  instalacion.idinstalacion, 
                        instalacion.nombre, 
                        instalacion.cantidad_maxima_personas,
                        instalacion.domicilio
              FROM 
                public.instalacion 
              where 
                $where
                ";

      } else {
         $sql ="SELECT   instalacion.idinstalacion, 
                      instalacion.nombre, 
                      instalacion.cantidad_maxima_personas,
                      instalacion.domicilio
              FROM 
                public.instalacion";

      }
     
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
                categoria_motivo.descripcion ilike $categoria_motivo
                ";
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
                    nro_personas,
                    monto
            FROM 
                public.solicitud_reserva
            inner join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join estado on estado.idestado = solicitud_reserva.idestado
            inner join motivo_tipo_socio using(idmotivo_tipo_socio)
            inner join motivo on motivo.idmotivo = motivo_tipo_socio.idmotivo
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

  function get_motivo_por_tipo_socio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idmotivo_tipo_socio, 
                    tipo_socio.descripcion as tipo_socio, 
                    motivo.descripcion as motivo,
                    monto_reserva, 
                    monto_limpieza_mantenimiento, 
                    monto_garantia,
                    COALESCE(monto_reserva,0) + COALESCE(monto_limpieza_mantenimiento,0) + COALESCE(monto_garantia,0) as total
            FROM 
            public.motivo_tipo_socio
            inner join tipo_socio using(idtipo_socio)
            inner join motivo using(idmotivo)
            inner join afiliacion using (idtipo_socio)
            where
              afiliacion.activa =  true and
              $where";
    return consultar_fuente($sql);
  }  

  function get_listado_motivo_por_tipo_socio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idmotivo_tipo_socio, 
                    tipo_socio.descripcion as tipo_socio, 
                    motivo.descripcion as motivo,
                    tipo_socio.descripcion||' - '||motivo.descripcion as motivo_tipo,
                    monto_reserva, 
                    monto_limpieza_mantenimiento, 
                    monto_garantia,
                    COALESCE(monto_reserva,0) + COALESCE(monto_limpieza_mantenimiento,0) + COALESCE(monto_garantia,0) as total
            FROM 
            public.motivo_tipo_socio
            inner join tipo_socio using(idtipo_socio)
            inner join motivo using(idmotivo)
            where
             $where";
    return consultar_fuente($sql);
  } 

  function get_monto_segun_motivo_por_tipo_socio($idmotivo_tipo_socio)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  
                    COALESCE(monto_reserva,0) + COALESCE(monto_limpieza_mantenimiento,0) + COALESCE(monto_garantia,0) as total
            FROM 
              public.motivo_tipo_socio
            where
              idmotivo_tipo_socio =  $idmotivo_tipo_socio";
    $motivo = consultar_fuente($sql);
    if(isset($motivo[0]['total']))
    {
      return $motivo[0]['total']; 
    }
  }

  function get_configuracion()
  {
    $sql = "SELECT  edad_maxima_bolsita_escolar,  
                    dias_confirmacion_reserva, 
                    limite_dias_para_reserva, 
                    porcentaje_confirmacion_reserva, 
                    minimo_meses_afiliacion, 
                    idconfiguracion
            FROM 
              public.configuracion;";
    $res = consultar_fuente($sql);
    if (isset($res[0]))
    {
      return $res[0]; 
    }
  }
}
?>