
DROP INDEX public.idx_afiliacion_solicitada;

CREATE UNIQUE INDEX idx_afiliacion_solicitada
  ON public.afiliacion
  USING btree
  (idpersona, idtipo_socio)
  WHERE (solicitada = true AND activa = false) or (solicitada = false AND activa = true);


DROP INDEX public.idx_afiliacion;

CREATE UNIQUE INDEX idx_afiliado
  ON public.afiliacion
  USING btree
  (idpersona, idtipo_socio)
  WHERE activa = true;


ALTER TABLE public.afiliacion ADD COLUMN solicitada boolean;
ALTER TABLE public.afiliacion ALTER COLUMN solicitada SET DEFAULT false;
