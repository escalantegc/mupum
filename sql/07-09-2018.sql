ALTER TABLE public.configuracion_colonia ADD COLUMN cupo integer;
ALTER TABLE public.configuracion_colonia ADD COLUMN hora_concentracion time without time zone;
ALTER TABLE public.configuracion_colonia ADD COLUMN hora_salida time without time zone;
ALTER TABLE public.configuracion_colonia ADD COLUMN hora_llegada time without time zone;
ALTER TABLE public.configuracion_colonia ADD COLUMN hora_finalizacion time without time zone;
ALTER TABLE public.configuracion_colonia ADD COLUMN direccion character(100);


-- Function: public.cargos_de_una_persona(integer)

-- DROP FUNCTION public.cargos_de_una_persona(integer);

CREATE OR REPLACE FUNCTION public.colonos_de_un_titular(integer)
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
		afiliacion.idafiliacion = $1) LOOP
		colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

