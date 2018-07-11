DROP INDEX public.idx_motivo_por_tipo_socio;

CREATE UNIQUE INDEX idx_motivo_por_tipo_socio
  ON public.motivo_tipo_socio
  USING btree
  (idtipo_socio, idmotivo, idinstalacion);