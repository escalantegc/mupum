ALTER TABLE public.persona ALTER COLUMN idlocalidad DROP NOT NULL;
ALTER TABLE public.tipo_socio ADD COLUMN titular boolean;
ALTER TABLE public.tipo_socio ALTER COLUMN titular SET DEFAULT false;


DROP INDEX public.idx_afiliacion;

CREATE UNIQUE INDEX idx_afiliacion
  ON public.afiliacion
  USING btree
  (idpersona, idtipo_socio)
  WHERE activa = true;
