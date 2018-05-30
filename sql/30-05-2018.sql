DROP INDEX public.idx_estado;

CREATE UNIQUE INDEX idx_estado
  ON public.estado
  USING btree
  (descripcion COLLATE pg_catalog."default", idcategoria_estado);


-- Foreign Key: public.afiliacion_idestado_fkey

-- ALTER TABLE public.afiliacion DROP CONSTRAINT afiliacion_idestado_fkey;

ALTER TABLE public.afiliacion
  ADD CONSTRAINT afiliacion_idestado_fkey FOREIGN KEY (idestado)
      REFERENCES public.estado (idestado) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;

-- Foreign Key: public.afiliacion_idpersona_fkey

-- ALTER TABLE public.afiliacion DROP CONSTRAINT afiliacion_idpersona_fkey;

ALTER TABLE public.afiliacion
  ADD CONSTRAINT afiliacion_idpersona_fkey FOREIGN KEY (idpersona)
      REFERENCES public.persona (idpersona) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;

-- Foreign Key: public.afiliacion_idtipo_socio_fkey

-- ALTER TABLE public.afiliacion DROP CONSTRAINT afiliacion_idtipo_socio_fkey;

ALTER TABLE public.afiliacion
  ADD CONSTRAINT afiliacion_idtipo_socio_fkey FOREIGN KEY (idtipo_socio)
      REFERENCES public.tipo_socio (idtipo_socio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;


-- Index: public.idx_provincia

-- DROP INDEX public.idx_provincia;

CREATE UNIQUE INDEX idx_provincia
  ON public.provincia
  USING btree
  (descripcion COLLATE pg_catalog."default");
