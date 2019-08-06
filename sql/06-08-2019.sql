ALTER TABLE public.solicitud_subsidio ADD COLUMN idpersona_familia integer;
CREATE UNIQUE INDEX idx_idpersona_familia
  ON public.solicitud_subsidio
  USING btree
  (idpersona_familia);

ALTER TABLE public.tipo_subsidio ADD COLUMN por_hijo boolean;
ALTER TABLE public.tipo_subsidio ALTER COLUMN por_hijo SET DEFAULT false;
