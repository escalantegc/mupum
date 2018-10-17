
DROP INDEX public.detalle_inscripcion_pileta_idpersona_familia_idx;

CREATE UNIQUE INDEX detalle_inscripcion_pileta_idpersona_familia_idx
  ON public.detalle_inscripcion_pileta
  USING btree
  (idinscripcion_pileta, idpersona_familia);

  
DROP INDEX public.inscripcion_pileta_idtemporada_pileta_idafiliacion_idx;

CREATE UNIQUE INDEX inscripcion_pileta_idtemporada_pileta_idafiliacion_idx
  ON public.inscripcion_pileta
  USING btree
  (idtemporada_pileta, idafiliacion);

ALTER TABLE public.detalle_pago_inscripcion_pileta
  ADD CONSTRAINT detalle_pago_inscripcion_pileta_idinscripcion_pileta_fkey FOREIGN KEY (idinscripcion_pileta)
      REFERENCES public.inscripcion_pileta (idinscripcion_pileta) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;


ALTER TABLE public.detalle_inscripcion_pileta DROP CONSTRAINT detalle_inscripcion_pileta_idinscripcion_pileta_fkey;

ALTER TABLE public.detalle_inscripcion_pileta
  ADD CONSTRAINT detalle_inscripcion_pileta_idinscripcion_pileta_fkey FOREIGN KEY (idinscripcion_pileta)
      REFERENCES public.inscripcion_pileta (idinscripcion_pileta) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;



-- Function: public.cantidad_numeros_vendidos_talonario_bono_colaboracion(integer)

-- DROP FUNCTION public.cantidad_numeros_vendidos_talonario_bono_colaboracion(integer);

CREATE OR REPLACE FUNCTION public.cantidad_numeros_vendidos_talonario_bono(integer)
  RETURNS integer AS
$BODY$
DECLARE
    cantidad integer;
    
BEGIN
  cantidad := (SELECT count(*) as cant
		FROM public.talonario_nros_bono
	      where
	      idtalonario_bono = $1 and
	      disponible =false);
      
   RETURN cantidad;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

