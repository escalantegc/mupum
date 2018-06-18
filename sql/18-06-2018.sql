-- Index: public.idx_motivo_por_tipo_socio

-- DROP INDEX public.idx_motivo_por_tipo_socio;

CREATE UNIQUE INDEX idx_motivo_por_tipo_socio
  ON public.motivo_tipo_socio
  USING btree
  (idtipo_socio, idmotivo);


ALTER TABLE public.solicitud_reserva ALTER COLUMN nro_personas DROP NOT NULL;
ALTER TABLE public.solicitud_reserva ALTER COLUMN idmotivo DROP NOT NULL;


-- Function: public.cargos_de_una_persona(integer)

-- DROP FUNCTION public.cargos_de_una_persona(integer);

CREATE OR REPLACE FUNCTION traer_instalaciones_ocupadas(date)
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
		where solicitud_reserva.fecha = $1)
	 LOOP
	instalaciones:=  coalesce(instalaciones,'') || coalesce(reg.nombre,'') ||coalesce(' | ','');
	END LOOP;
   RETURN instalaciones;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
