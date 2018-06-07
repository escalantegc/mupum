CREATE UNIQUE INDEX idx_instalacion
  ON public.instalacion
  USING btree
  (nombre COLLATE pg_catalog."default");


ALTER TABLE public.solicitud_reserva
  ADD CONSTRAINT solicitud_reserva_idinstalacion_fkey FOREIGN KEY (idinstalacion)
      REFERENCES public.instalacion (idinstalacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;


      CREATE UNIQUE INDEX idx_motivo
  ON public.motivo
  USING btree
  (descripcion COLLATE pg_catalog."default");
