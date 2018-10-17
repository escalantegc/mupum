
CREATE OR REPLACE FUNCTION public.telefonos_del_colono(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    telefonos text;
BEGIN
    FOR REG IN (SELECT  tipo_telefono.descripcion ||' Nro :'||nro_telefono||' | Referencia: '|| parentesco.descripcion as telefono
    FROM public.telefono_inscripcion_colono
    inner join tipo_telefono using(idtipo_telefono)
    inner join parentesco using(idparentesco)
    where
    telefono_inscripcion_colono.idinscripcion_colono =$1) 
  LOOP
      telefonos:=  coalesce(telefonos,'') ||' | '||coalesce(reg.telefono,'');

       
    END LOOP;
   RETURN telefonos;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;



-- Function: public.premios_del_bono_colaboracion(integer)

-- DROP FUNCTION public.premios_del_bono_colaboracion(integer);

CREATE OR REPLACE FUNCTION public.premios_del_bono_colaboracion(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    premios text;
BEGIN
    FOR REG IN (SELECT 'Nro :'||nro_premio||' - '||descripcion as premio
        FROM public.premio_sorteo
        where
        idtalonario_bono_colaboracion  =$1) 
  LOOP
      premios:=  coalesce(premios,'') ||' | '||coalesce(reg.premio,'');

       
    END LOOP;
   RETURN premios;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.premios_del_bono_colaboracion(integer)
  OWNER TO postgres;


-- Function: public.cantidad_numeros_vendidos_talonario_bono_colaboracion(integer)


CREATE OR REPLACE FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer)
  RETURNS integer AS
$BODY$
DECLARE
    cantidad integer;
    
BEGIN
  cantidad := (SELECT count(*) as cantidad FROM public.talonario_nros_bono_colaboracion
      where
      idtalonario_bono_colaboracion = $1 );
      
   RETURN cantidad;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;




-- Function: public.traer_instalaciones_ocupadas(date)

-- DROP FUNCTION public.traer_instalaciones_ocupadas(date);

CREATE OR REPLACE FUNCTION public.traer_instalaciones_ocupadas(date)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    instalaciones text;
BEGIN
    FOR REG IN (SELECT  
                    instalacion.nombre
            FROM 
              public.solicitud_reserva
              inner join estado using (idestado)
              inner join instalacion using (idinstalacion)
    where 
    estado.cancelada = false and
    solicitud_reserva.fecha = $1)
  LOOP
 instalaciones:=  coalesce(instalaciones,'') || coalesce(reg.nombre,'') ||coalesce(chr(10),'');
 END LOOP;
   RETURN instalaciones;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.traer_instalaciones_ocupadas(date)
  OWNER TO postgres;

-- Function: public.familiar_de_un_titular(integer)

-- DROP FUNCTION public.familiar_de_un_titular(integer);

CREATE OR REPLACE FUNCTION public.familiar_de_un_titular(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    familiares text;
BEGIN
    FOR REG IN (SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||', '||persona.nombres as titular,
                     parentesco.descripcion||': '||familiar.apellido ||', '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||' - '|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            inner join detalle_inscripcion_pileta on detalle_inscripcion_pileta.idpersona_familia= familia.idpersona_familia
            where
    persona.idpersona = $1) LOOP
  familiares:=  coalesce(familiares,'') ||' | '||coalesce(reg.familiar_titular,'');

       
    END LOOP;
   RETURN familiares;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.familiar_de_un_titular(integer)
  OWNER TO postgres;
