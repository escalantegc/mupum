ALTER TABLE public.cuota_societaria
  ADD CONSTRAINT cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;
CREATE UNIQUE INDEX idx_periodo
  ON public.cabecera_cuota_societaria
  USING btree
  (periodo COLLATE pg_catalog."default");
