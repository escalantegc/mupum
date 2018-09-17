
-- Table: public.concepto_liquidacion

-- DROP TABLE public.concepto_liquidacion;

CREATE TABLE public.concepto_liquidacion
(
  idconcepto_liquidacion integer NOT NULL DEFAULT nextval('concepto_liquidacion_idconceptop_liquidacion_seq'::regclass),
  descripcion character(100) NOT NULL,
  codigo character(4),
  CONSTRAINT concepto_liquidacion_pkey PRIMARY KEY (idconcepto_liquidacion)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.concepto_liquidacion
  OWNER TO postgres;

-- Index: public.idx_codigo_concepto

-- DROP INDEX public.idx_codigo_concepto;

CREATE UNIQUE INDEX idx_codigo_concepto
  ON public.concepto_liquidacion
  USING btree
  (codigo COLLATE pg_catalog."default");


-- Table: public.cuota_societaria

-- DROP TABLE public.cuota_societaria;

CREATE TABLE public.cuota_societaria
(
  idcuota_societaria integer NOT NULL DEFAULT nextval('cuota_societaria_idcuota_societaria_seq'::regclass),
  idpersona integer NOT NULL,
  idafiliacion integer NOT NULL,
  cargo character(6) NOT NULL,
  idconcepto_liquidacion integer NOT NULL,
  monto double precision NOT NULL,
  CONSTRAINT cuota_societaria_pkey PRIMARY KEY (idcuota_societaria),
  CONSTRAINT cuota_societaria_idafiliacion_fkey FOREIGN KEY (idafiliacion, idpersona)
      REFERENCES public.afiliacion (idafiliacion, idpersona) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.cuota_societaria
  OWNER TO postgres;



-- Table: public.gasto_infraestructura

-- DROP TABLE public.gasto_infraestructura;

-- Table: public.gasto_infraestructura

-- DROP TABLE public.gasto_infraestructura;

CREATE TABLE public.gasto_infraestructura
(
  idgasto_infraestructura integer NOT NULL DEFAULT nextval('gasto_infraestructura_idgasto_infraestructura_seq'::regclass),
  idconcepto integer NOT NULL,
  idcomercio integer,
  fecha_pago date,
  monto double precision NOT NULL,
  periodo character(7),
  CONSTRAINT gasto_infraestructura_pkey PRIMARY KEY (idgasto_infraestructura),
  CONSTRAINT gasto_infraestructura_idconcepto_fkey FOREIGN KEY (idconcepto)
      REFERENCES public.concepto (idconcepto) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT gasto_infraestructura_idproveedor_fkey FOREIGN KEY (idcomercio)
      REFERENCES public.comercio (idcomercio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.gasto_infraestructura
  OWNER TO postgres;

-- Table: public.detalle_pago_gasto_infraestructura

-- DROP TABLE public.detalle_pago_gasto_infraestructura;

CREATE TABLE public.detalle_pago_gasto_infraestructura
(
  iddetalle_pago_gasto_infraestructura integer NOT NULL DEFAULT nextval('detalle_pago_gasto_infraestru_iddetalle_pago_gasto_infraest_seq'::regclass),
  idgasto_infraestructura integer,
  idforma_pago integer NOT NULL,
  monto double precision NOT NULL,
  nro_cheque_transaccion character(50),
  fecha_pago date,
  CONSTRAINT detalle_pago_gasto_infraestructura_pkey PRIMARY KEY (iddetalle_pago_gasto_infraestructura),
  CONSTRAINT detalle_pago_gasto_infraestructura_idforma_pago_fkey FOREIGN KEY (idforma_pago)
      REFERENCES public.forma_pago (idforma_pago) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT detalle_pago_gasto_infraestructura_idgasto_infraestructura_fkey FOREIGN KEY (idgasto_infraestructura)
      REFERENCES public.gasto_infraestructura (idgasto_infraestructura) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.detalle_pago_gasto_infraestructura
  OWNER TO postgres;



ALTER TABLE public.forma_pago ADD COLUMN requiere_nro_comprobante boolean;
ALTER TABLE public.forma_pago ALTER COLUMN requiere_nro_comprobante SET DEFAULT false;


ALTER TABLE public.concepto ADD COLUMN pago_infraestructura boolean;
ALTER TABLE public.concepto ALTER COLUMN pago_infraestructura SET DEFAULT false;


