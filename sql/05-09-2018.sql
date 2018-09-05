CREATE UNIQUE INDEX idx_anio_colonia
  ON public.configuracion_colonia
  USING btree
  (anio);

