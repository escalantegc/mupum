-- Index: public.idx_inscripcion_colono

-- DROP INDEX public.idx_inscripcion_colono;

CREATE UNIQUE INDEX idx_inscripcion_colono
  ON public.inscripcion_colono
  USING btree
  (idconfiguracion_colonia, idpersona_familia);

ALTER TABLE public.inscripcion_colono ADD COLUMN baja boolean;
ALTER TABLE public.inscripcion_colono ALTER COLUMN baja SET DEFAULT false;
