ALTER TABLE public.comercio ADD COLUMN tipo character(2);
ALTER TABLE public.comercio ADD COLUMN nro_telefono character(10);
ALTER TABLE public.comercio ADD COLUMN cuit character(11);
ALTER TABLE public.comercio ADD COLUMN cbu character(25);


ALTER TABLE public.concepto ADD COLUMN proveedor boolean;
ALTER TABLE public.concepto ALTER COLUMN proveedor SET DEFAULT false;


-- Function: public.colonos_de_un_titular(integer)

-- DROP FUNCTION public.colonos_de_un_titular(integer);

CREATE OR REPLACE FUNCTION public.colonos_de_un_titular_con_plan(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    colonos text;
BEGIN
    FOR REG IN (SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            where 
  afiliacion.idafiliacion = $1 and
  cantidad_cuotas > 0
  group by 
                    idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido,
                    colono.nombres ,
                    tipo_socio.descripcion,
                    persona.apellido ,
                    persona.nombres) LOOP
  colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- Function: public.colonos_de_un_titular(integer)

-- DROP FUNCTION public.colonos_de_un_titular(integer);

CREATE OR REPLACE FUNCTION public.colonos_de_un_titular_sin_plan(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    colonos text;
BEGIN
    FOR REG IN (SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            where 
  afiliacion.idafiliacion = $1 and
  cantidad_cuotas =0
  group by 
                    idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido,
                    colono.nombres ,
                    tipo_socio.descripcion,
                    persona.apellido ,
                    persona.nombres) LOOP
  colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

