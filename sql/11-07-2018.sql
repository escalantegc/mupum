DROP INDEX public.idx_motivo_por_tipo_socio;

CREATE UNIQUE INDEX idx_motivo_por_tipo_socio
  ON public.motivo_tipo_socio
  USING btree
  (idtipo_socio, idmotivo, idinstalacion);


  ALTER TABLE public.detalle_pago
  ADD CONSTRAINT detalle_pago_idconcepto_fkey FOREIGN KEY (idconcepto)
      REFERENCES public.concepto (idconcepto) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE public.detalle_pago ADD COLUMN idconcepto integer;
ALTER TABLE public.detalle_pago ADD COLUMN descripcion character(50);


-- Table: public.detalle_modificacion_monto

-- DROP TABLE public.detalle_modificacion_monto;

CREATE TABLE public.detalle_modificacion_monto
(
 iddetalle_modificacion_monto serial NOT NULL ,
  idconcepto integer NOT NULL,
  idsolicitud_reserva integer NOT NULL,
  idforma_pago integer NOT NULL,
  monto double precision NOT NULL,
  descripcion character(50),
  tipo_movimiento character(3), -- descuento...
  CONSTRAINT detalle_modificacion_monto_pkey PRIMARY KEY (iddetalle_modificacion_monto),
  CONSTRAINT detalle_modificacion_monto_idconcepto_fkey FOREIGN KEY (idconcepto)
      REFERENCES public.concepto (idconcepto) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT detalle_modificacion_monto_idforma_pago_fkey FOREIGN KEY (idforma_pago)
      REFERENCES public.forma_pago (idforma_pago) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT detalle_modificacion_monto_idsolicitud_reserva_fkey FOREIGN KEY (idsolicitud_reserva)
      REFERENCES public.solicitud_reserva (idsolicitud_reserva) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.detalle_modificacion_monto
  OWNER TO postgres;
COMMENT ON COLUMN public.detalle_modificacion_monto.tipo_movimiento IS 'descuento
aumento';

