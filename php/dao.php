<?php
class dao 
{

  function get_sql_usuario()
  {

    $usuario = toba::usuario()->get_id();
    $perfil = toba::usuario()->get_perfiles_funcionales();
    $usuario = quote("%{$usuario}%");
    $sql = '';
    if ($perfil[0] == 'afiliado')
    {
      $sql = ' persona.nro_documento ilike '.trim($usuario);
    } else {
      $sql = ' 1 = 1 ';
    }
    return $sql;
  }

	function get_listado_persona($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }

    $sql = "SELECT  idpersona, 
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
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          where
            $where 
          order by
            apellido,nombres";
         
      return consultar_fuente($sql);
  }

  function get_listado_socios_libre($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }

    $sql = "SELECT  idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
             nro_documento as usuario, 
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
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          where
            legajo is not null and
            $where 
          order by
            apellido,nombres";
      return consultar_fuente($sql);
  }

  function get_listado_socios($where = null)
	{
    $sql = '';
    $sql_usuario = self::get_sql_usuario();
		if (isset($where))
		{
			 $sql = "SELECT  idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
            nro_documento, 
            tipo_documento.sigla as tipo_documento,
            apellido,
            nombres,
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
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
            tipo_socio.descripcion as tipo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          inner join afiliacion using (idpersona)
          inner join tipo_socio using(idtipo_socio)
          where
            afiliacion.activa = true and
            $sql_usuario and
            $where 
          order by
            apellido,nombres";
		} else {
      $sql = "SELECT  idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
            nro_documento, 
            tipo_documento.sigla as tipo_documento,
            apellido,
            nombres,
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
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
            tipo_socio.descripcion as tipo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          inner join afiliacion using (idpersona)
          inner join tipo_socio using(idtipo_socio)
          where
            afiliacion.activa = true and
            tipo_socio.titular = true and
            $sql_usuario 
          order by
            apellido,nombres";
    }
  
   
		

  		
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
                    titular,
                    liquidacion
  				FROM public.tipo_socio
  				where
  					$where
  				order by
  					titular desc,descripcion";
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

  function get_estado_cancelada_segun_categoria($categoria_estado = null)
  {
    $categoria_estado = quote("%{$categoria_estado}%");
    $sql = "SELECT  estado.idestado, 
            estado.descripcion

        FROM 
          public.estado
        inner join categoria_estado using (idcategoria_estado)
        WHERE
          categoria_estado.descripcion ilike $categoria_estado and
          cancelada=true ";
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
                    fecha_solicitud_cancelacion,
                    extract(YEAR FROM age(current_date::DATE ,fecha_alta::DATE))*12 + extract(MONTH FROM age (current_date::DATE, fecha_alta::DATE))as meses_afiliacion
            FROM
                public.afiliacion
            left outer join estado using (idestado)
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
                    afiliacion.solicitada,
                    persona.legajo
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
                    solicita_cancelacion,
                    persona.legajo
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

  function get_tipo_socio($idtipo_socio = null)
	{
      $datos['tipo'] = 'notitular';
    	$sql = "SELECT  idtipo_socio, 
                        descripcion, 
                        titular
                FROM 
                  public.tipo_socio
                WHERE
                  idtipo_socio = $idtipo_socio";
      $res = consultar_fuente($sql);
      if ($res[0]['titular'] == 1)
      {
        $datos['tipo'] = 'titular';
      }
      return $datos;
  		
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
    $sql_usuario = self::get_sql_usuario();
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                  persona.apellido||', '|| persona.nombres as persona
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            where 
              activa = true and
              $sql_usuario";

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
                      cantidad_personas_reserva,
                      cantidad_maxima_personas,
                      domicilio
              FROM 
                public.instalacion 
              where 
                $where";
      return consultar_fuente($sql);
  }  

  function get_listado_instalacion_disponible ($idafiliacion=null, $fecha = null)
  {
      $sql = "SELECT idinstalacion  
              FROM public.solicitud_reserva  
              inner join estado on estado.idestado = solicitud_reserva.idestado 
              where 
                fecha = $fecha and 
                estado.cancelada = false";
      $solicitudes = consultar_fuente($sql);
      
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
                inner join motivo_tipo_socio on motivo_tipo_socio.idinstalacion = instalacion.idinstalacion
                inner join afiliacion on motivo_tipo_socio.idtipo_socio = afiliacion.idtipo_socio
              where 
                afiliacion.idafiliacion = $idafiliacion and
                $where
                ";

      } else {
         $sql ="SELECT   instalacion.idinstalacion, 
                      instalacion.nombre, 
                      instalacion.cantidad_maxima_personas,
                      instalacion.domicilio
              FROM 
                public.instalacion 
              inner join motivo_tipo_socio on motivo_tipo_socio.idinstalacion = instalacion.idinstalacion
              inner join afiliacion on motivo_tipo_socio.idtipo_socio = afiliacion.idtipo_socio
              where 
                afiliacion.idafiliacion = $idafiliacion";

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
                    solicitud_reserva.monto,
                    monto_final,
                    sum (detalle_pago.monto) as pago_detalle
            FROM 
                public.solicitud_reserva
            inner join afiliacion using(idafiliacion)
            left outer join detalle_pago using(idsolicitud_reserva)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join estado on estado.idestado = solicitud_reserva.idestado
            inner join motivo_tipo_socio using(idmotivo_tipo_socio)
            inner join motivo on motivo.idmotivo = motivo_tipo_socio.idmotivo
            inner join instalacion on solicitud_reserva.idinstalacion = instalacion.idinstalacion
            where
              $where
            group by 
              solicitud_reserva.idsolicitud_reserva,
              persona.apellido ,
              persona.nombres ,
              fecha, 
              instalacion.nombre , 
              estado.descripcion , 
              motivo.descripcion , 
              nro_personas,
              solicitud_reserva.monto,
              monto_final
            order by 
              fecha desc";
      $datos = consultar_fuente($sql);
      $resultado = array();
      foreach ($datos as $dato) 
      {
        if ($dato['monto_final']==$dato['pago_detalle'])
        {
          $dato['pago'] = 1;
        } else{
           $dato['pago'] = 0;
        }
        $resultado[] = $dato;
      }
      return $resultado;
  }
  function get_listado_reserva_mes_en_curso($where = null)
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
                    solicitud_reserva.monto,
                    monto_final,
                    sum (detalle_pago.monto) as pago_detalle
            FROM 
                public.solicitud_reserva
            inner join afiliacion using(idafiliacion)
            left outer join detalle_pago using(idsolicitud_reserva)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join estado on estado.idestado = solicitud_reserva.idestado
            inner join motivo_tipo_socio using(idmotivo_tipo_socio)
            inner join motivo on motivo.idmotivo = motivo_tipo_socio.idmotivo
            inner join instalacion on solicitud_reserva.idinstalacion = instalacion.idinstalacion
            where
              extract(MONTH FROM fecha) = extract(MONTH FROM current_date) and
              $where
            group by 
              solicitud_reserva.idsolicitud_reserva,
              persona.apellido ,
              persona.nombres ,
              fecha, 
              instalacion.nombre , 
              estado.descripcion , 
              motivo.descripcion , 
              nro_personas,
              solicitud_reserva.monto,
              monto_final,
              estado.confirmada 
            order by 
              estado.confirmada desc,fecha desc";
      $datos = consultar_fuente($sql);
      $resultado = array();
      foreach ($datos as $dato) 
      {
        if ($dato['monto_final']==$dato['pago_detalle'])
        {
          $dato['pago'] = 1;
        } else{
           $dato['pago'] = 0;
        }
        $resultado[] = $dato;
      }
      return $resultado;
  }
  
  function get_listado_reserva_historial($where = null)
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
                    solicitud_reserva.monto,
                    monto_final,
                    sum (detalle_pago.monto) as pago_detalle
            FROM 
                public.solicitud_reserva
            inner join afiliacion using(idafiliacion)
            left outer join detalle_pago using(idsolicitud_reserva)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join estado on estado.idestado = solicitud_reserva.idestado
            inner join motivo_tipo_socio using(idmotivo_tipo_socio)
            inner join motivo on motivo.idmotivo = motivo_tipo_socio.idmotivo
            inner join instalacion on solicitud_reserva.idinstalacion = instalacion.idinstalacion
            where
              extract(MONTH FROM fecha) != extract(MONTH FROM current_date) and
              $where
            group by 
              solicitud_reserva.idsolicitud_reserva,
              persona.apellido ,
              persona.nombres ,
              fecha, 
              instalacion.nombre , 
              estado.descripcion , 
              motivo.descripcion , 
              nro_personas,
              solicitud_reserva.monto,
              monto_final
            order by 
              fecha desc";
      $datos = consultar_fuente($sql);
      $resultado = array();
      foreach ($datos as $dato) 
      {
        if ($dato['monto_final']==$dato['pago_detalle'])
        {
          $dato['pago'] = 1;
        } else{
           $dato['pago'] = 0;
        }
        $resultado[] = $dato;
      }
      return $resultado;
  }

  function get_listado_forma_pago($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql = "SELECT  idforma_pago, 
                      descripcion,
                      planilla

              FROM 
                  public.forma_pago 
              
              where
                $where
              order by
                  descripcion";
      return consultar_fuente($sql);
  } 

  function get_listado_forma_pago_planilla()
  {
    
      $sql = "SELECT  idforma_pago, 
                      descripcion
              FROM 
                  public.forma_pago 
              
              where
                planilla = true 
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
                    instalacion.nombre as instalacion,
                    monto_persona_extra,
                    porcentaje_senia,
                    COALESCE(monto_reserva,0) + COALESCE(monto_limpieza_mantenimiento,0) + COALESCE(monto_garantia,0) as total
            FROM 
            public.motivo_tipo_socio
            inner join tipo_socio using(idtipo_socio)
            inner join motivo using(idmotivo)
            left outer join instalacion using(idinstalacion)
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
  function get_monto_porcentaje($idmotivo_tipo_socio)
  {
   
    $sql = "SELECT  
                    monto_reserva,
                    porcentaje_senia
            FROM 
              public.motivo_tipo_socio
            where
              idmotivo_tipo_socio =  $idmotivo_tipo_socio";
    $motivo = consultar_fuente($sql);
    if((isset($motivo[0]['monto_reserva'])) and (isset($motivo[0]['porcentaje_senia'])))
    {
        $datos['monto_porcentaje'] = $motivo[0]['monto_reserva'] *  ($motivo[0]['porcentaje_senia']/100);
        return $datos;
    }
  }

  function get_porcentaje_senia_reserva_segun_motivo_por_tipo_socio($idmotivo_tipo_socio)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  
                    porcentaje_senia
            FROM 
              public.motivo_tipo_socio
            where
              idmotivo_tipo_socio =  $idmotivo_tipo_socio";
    $motivo = consultar_fuente($sql);
    if(isset($motivo[0]['porcentaje_senia']))
    {
      return $motivo[0]['porcentaje_senia']; 
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

  function get_listado_claustro($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idclaustro, 
                    descripcion
            FROM 
              public.claustro
            where
              $where";
    return consultar_fuente($sql);
  }

  function get_listado_unidad_academica($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idunidad_academica, 
                    sigla, 
                    descripcion
            FROM 
            public.unidad_academica
            where
              $where";
    return consultar_fuente($sql);
  }

  function get_encabezado()
  {
    $sql = "SELECT  idencabezado, 
                    nombre_institucion, 
                    direccion, 
                    'Telefono: '||telefono as telefono, 
                    logo
            FROM 
              public.encabezado;";
    $res = consultar_fuente($sql);
    if(isset($res[0]))
    {
      return $res[0];
    }
  }

  function get_listado_novedades_familia($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  logs_familia.idpersona, 
                    logs_familia.idpersona_familia, 
                    logs_persona.apellido ||' - '||logs_persona.nombres as titular,
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    logs_parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    logs_familia.auditoria_usuario, 
                    logs_familia.auditoria_fecha, 
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    (CASE WHEN logs_familia.auditoria_operacion = 'I' then 'ALTA' else (CASE WHEN logs_familia.auditoria_operacion = 'D' then 'BAJA' else 'MODIFICACION' end) end) as tipo_movimiento, 
                    logs_familia.auditoria_id_solicitud,
                    logs_tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    public_auditoria.logs_familia
            inner join public_auditoria.logs_persona on logs_persona.idpersona=logs_familia.idpersona
            inner join public_auditoria.logs_persona familiar on familiar.idpersona=logs_familia.idpersona_familia
            inner join public_auditoria.logs_parentesco using(idparentesco)
            inner join public_auditoria.logs_tipo_documento on familiar.idtipo_documento = logs_tipo_documento.idtipo_documento

            where
              logs_familia.auditoria_operacion != 'U' and
              $where
            order by
              logs_familia.auditoria_fecha desc";
              
   /* $sql2 = "SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||' - '||persona.nombres as titular,
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga
            FROM 
                    public.familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)";*/
      return toba::db('auditoria')->consultar($sql);  


  }
  function get_perfiles_mupum()
  {
      $sql = "SELECT usuario_grupo_acc
              FROM 
                desarrollo.apex_usuario_grupo_acc
              where 
                proyecto = 'mupum' and
                usuario_grupo_acc != 'admin'";
      return toba::db('usuarios')->consultar($sql);  
  }

  function get_listado_categoria_comercio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idcategoria_comercio, 
                    descripcion
            FROM 
              public.categoria_comercio
            where
              $where";
    return consultar_fuente($sql);
  }

  function get_listado_comercios($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql =" SELECT   idcomercio, 
                    nombre, 
                    direccion, 
                    localidad.descripcion as localidad, 
                    categoria_comercio.descripcion as categoria
            FROM public.comercio
            inner join localidad using(idlocalidad)
            inner join categoria_comercio using(idcategoria_comercio)
            where
              $where";
    return consultar_fuente($sql);
  }  
  function get_listado_concepto($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql =" SELECT idconcepto, 
                  descripcion,
                  senia
            FROM public.concepto

            where
              $where";
    return consultar_fuente($sql);
  }

  function get_listado_concepto_senia()
  {
    $sql =" SELECT idconcepto, 
                  descripcion
            FROM public.concepto

            where
              senia = true";
    return consultar_fuente($sql);
  }

  function get_mensaje_excedente_por_persona_reserva($idinstalacion = null, $idmotivo_tipo_socio = null)
  {
    $sql1 = " SELECT monto_persona_extra
              FROM 
                public.motivo_tipo_socio
              where 
              idmotivo_tipo_socio = $idmotivo_tipo_socio";
    $montos = consultar_fuente($sql1);         

    $sql2 = " SELECT  cantidad_maxima_personas,  
                      cantidad_personas_reserva
              FROM 
                public.instalacion
              where 
                idinstalacion = $idinstalacion";
    $cantidades = consultar_fuente($sql2);  

    $monto_excedente = $montos[0]['monto_persona_extra'];
    $capacidad_permitida =  $cantidades[0]['cantidad_personas_reserva'];
    $capacidad_maxima =  $cantidades[0]['cantidad_maxima_personas'];

    $mensaje =  '<p>El monto de la reserva es hasta '. $capacidad_permitida.' personas.</br> Por cada persona extra se cobrara: $'.$monto_excedente.'</p>';
   
    return $mensaje;
  }
  function get_monto_por_persona_excedente( $idmotivo_tipo_socio = null)
  {
    $sql1 = " SELECT monto_persona_extra
              FROM 
                public.motivo_tipo_socio
              where 
              idmotivo_tipo_socio = $idmotivo_tipo_socio";
    $montos = consultar_fuente($sql1);         

  

   return $montos[0]['monto_persona_extra'];
    
  }

  function get_capacidad_reserva_instalacion($idinstalacion = null)
  {
        

    $sql2 = " SELECT  cantidad_maxima_personas,  
                      cantidad_personas_reserva
              FROM 
                public.instalacion
              where 
                idinstalacion = $idinstalacion";
    $cantidades = consultar_fuente($sql2);  

    $capacidad_permitida =  $cantidades[0]['cantidad_personas_reserva'];
    $capacidad_maxima =  $cantidades[0]['cantidad_maxima_personas'];

    return $capacidad_permitida ;
  }

  function get_capacidad_maxima_instalacion($idinstalacion = null)
  {
        

    $sql2 = " SELECT  cantidad_maxima_personas,  
                      cantidad_personas_reserva
              FROM 
                public.instalacion
              where 
                idinstalacion = $idinstalacion";
    $cantidades = consultar_fuente($sql2);  

    $capacidad_permitida =  $cantidades[0]['cantidad_personas_reserva'];
    $capacidad_maxima =  $cantidades[0]['cantidad_maxima_personas'];

    return $capacidad_maxima ;
  }

  function get_listado_convenios($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
      $sql = "SELECT  idconvenio, 
                      categoria_comercio.descripcion as categoria, 
                      titulo, 
                      fecha_inicio, 
                      fecha_fin, 
                      maximo_cuotas, 
                      monto_maximo_mensual, 
                      permite_financiacion, 
                      activo, 
                      maneja_bono,
                      consumo_ticket
              FROM 
                public.convenio
              inner join categoria_comercio using (idcategoria_comercio)
              where 
                $where";
      return consultar_fuente($sql);
          
  }

  function get_listado_convenios_con_bono($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
      $sql = "SELECT  idconvenio, 
                      categoria_comercio.descripcion as categoria, 
                      titulo, 
                      fecha_inicio, 
                      fecha_fin, 
                      maximo_cuotas, 
                      monto_maximo_mensual, 
                      permite_financiacion, 
                      activo, 
                      maneja_bono,
                      consumo_ticket
              FROM 
                public.convenio
              inner join categoria_comercio using (idcategoria_comercio)
              where 
                maneja_bono = true and
                $where";
      return consultar_fuente($sql);
          
  }

  function get_listado_comercios_por_convenio($idconvenio = null)
  {
    
    $sql =" SELECT   comercio.idcomercio, 
                    comercio.nombre, 
                    comercio.direccion, 
                    localidad.descripcion as localidad, 
                    categoria_comercio.descripcion as categoria
            FROM public.comercio
            inner join localidad using(idlocalidad)
            inner join categoria_comercio using(idcategoria_comercio)
            inner join comercios_por_convenio using (idcomercio)
            where
              comercios_por_convenio.idconvenio = $idconvenio ";
    return consultar_fuente($sql);
  }  

  function get_comercios_combo_editable($filtro = null)
  {
    if (! isset($filtro) || trim($filtro)=='')
    {
      return array();
    }
    $filtro = quote("%{$filtro}%");

    $sql = "  SELECT idcomercio, categoria_comercio.descripcion ||'-'||nombre as nombre, direccion, idlocalidad
              FROM public.comercio
              inner join categoria_comercio using (idcategoria_comercio)
              WHERE 
                   categoria_comercio.descripcion ||'-'||nombre ilike $filtro limit 20 ";
    return consultar_fuente($sql);

  } 

  function get_descripcion_comercio($idcomercio = null)
  {
    $sql = "SELECT idcomercio, categoria_comercio.descripcion ||'-'||nombre as nombre, direccion, idlocalidad
              FROM public.comercio
            inner join categoria_comercio using (idcategoria_comercio)
            WHERE 
              comercio.idcomercio =  $idcomercio";
    $res = consultar_fuente($sql);
    if (isset($res[0]['nombre']))
    {
      return $res[0]['nombre'];
    }

  }

  function get_listado_reempadronamiento ($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idreempadronamiento, 
                    nombre, 
                    anio, 
                    activo
            FROM 
              public.reempadronamiento 
            where 
                $where";
      return consultar_fuente($sql);

  }  

  function get_listado_solicitudes_reempadronamientos ()
  {

    $sql = "SELECT  idreempadronamiento,  
                    idafiliacion, 
                    notificaciones, 
                    fecha_notificacion, 
                    atendida,
                    (apellido||', '|| nombres) as socio,
                    correo,
                    persona.idpersona,
                    tipo_documento.sigla ||'-'|| persona.nro_documento  as documento

            FROM 
              public.solicitud_reempadronamiento
            inner join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join tipo_documento on tipo_documento.idtipo_documento = persona.idtipo_documento
            where 
                  notificaciones = 0
            order by
                  apellido, nombres
            limit 50";
      return consultar_fuente($sql);

  }  

  function get_listado_solicitudes_reempadronamientos_enviadas ()
  {

    $sql = "SELECT  idreempadronamiento,  
                    idafiliacion, 
                    notificaciones, 
                    fecha_notificacion, 
                    atendida,
                    (apellido||', '|| nombres) as socio,
                    correo,
                    persona.idpersona,
                    tipo_documento.sigla ||'-'|| persona.nro_documento  as documento

            FROM 
              public.solicitud_reempadronamiento
            inner join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join tipo_documento on tipo_documento.idtipo_documento = persona.idtipo_documento
            where 
                  notificaciones != 0
            order by
                  apellido, nombres";
      return consultar_fuente($sql);

  }

   function get_solicitud_reempadronamiento_no_atenida ($idpersona = null)
  {

    $sql = "SELECT  idreempadronamiento,  
                    idafiliacion, 
                    notificaciones, 
                    fecha_notificacion, 
                    atendida,
                    (apellido||', '|| nombres) as socio,
                    correo,
                    persona.idpersona

            FROM 
              public.solicitud_reempadronamiento
            inner join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            where 
                  atendida = false and
                  persona.idpersona =$idpersona";
      return consultar_fuente($sql);

  }

  function get_correo_persona($idpersona = null)
  {
    $sql = "SELECT  correo
                  
            FROM 
              public.persona
            where   
              idpersona = $idpersona";
    $res = consultar_fuente($sql);
    if (isset($res[0]['correo']))
    {
      return $res[0]['correo'];
    }
  }

  function get_cantidad_solicitudes_no_atendidas()
  {
    $sql = "SELECT count(*) as cantidad 
            FROM public.solicitud_reempadronamiento
            where atendida = false";
    $res = consultar_fuente($sql);
    if (isset($res[0]['cantidad']))
    {
      return $res[0]['cantidad'];
    }
  }

  function get_listado_talonario_bono($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }

    $sql = "SELECT  talonario_bono.idtalonario_bono, 
                    convenio.titulo as convenio, 
                    comercio.nombre as comercio, 
                    nro_talonario, 
                    nro_inicio, 
                    nro_fin,
                    monto_bono
            FROM public.talonario_bono
            inner join comercio using(idcomercio)
            inner join convenio using(idconvenio)
            where 
                $where";
      return consultar_fuente($sql);
  }

  function get_idconvenio_talonario_bono($idtalonario_bono = null)
  {
    $sql = "SELECT idconvenio
            FROM 
              public.comercios_por_convenio
            inner join talonario_bono using(idconvenio)
            where 
              idtalonario_bono = $idtalonario_bono";
    $res = consultar_fuente($sql);
    if (isset($res[0]['idconvenio']))
    {
      return $res[0]; 
    }
  }  

  function get_idcomercio_talonario_bono($idtalonario_bono = null)
  {
    $sql = "SELECT idcomercio
            FROM 
              public.comercios_por_convenio
            inner join talonario_bono using(idcomercio)
            where 
              idtalonario_bono = $idtalonario_bono";
    $res = consultar_fuente($sql);
    if (isset($res[0]['idcomercio']))
    {
      return $res[0]['idcomercio']; 
    }
  }

  function  get_talonarios($idconvenio = null)
  {
    $sql = "SELECT  idtalonario_bono, 
                    comercio.nombre ||'- Talonario Nro: '|| nro_talonario as talonario
            FROM 
              public.talonario_bono
          inner join comercios_por_convenio using(idcomercio,idconvenio)
          inner join comercio on comercio.idcomercio = comercios_por_convenio.idcomercio
          WHERE
            comercios_por_convenio.idconvenio = $idconvenio ";
    return consultar_fuente($sql);
  }

  function get_listado_consumos_bono($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconsumo_bono, 
                    idtalonario_bono, 
                    numero_bono, 
                    (persona.apellido||', '|| persona.nombres) as socio,
                    talonario_bono.monto_bono,
                    comercio.nombre as comercio,
                    convenio.titulo as convenio,
                    numero_bono
            FROM 
                public.consumo_bonos
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner  join talonario_bono using(idtalonario_bono) 
            inner join convenio on convenio.idconvenio = talonario_bono.idconvenio
            inner join comercio on comercio.idcomercio= talonario_bono.idcomercio
            WHERE
              $where";
      return consultar_fuente($sql);
  }
}
?>
