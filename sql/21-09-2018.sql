ALTER TABLE public.cuota_societaria
  ADD CONSTRAINT cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;
CREATE UNIQUE INDEX idx_periodo
  ON public.cabecera_cuota_societaria
  USING btree
  (periodo COLLATE pg_catalog."default");


-- Table: public.concepto_liquidacion

-- DROP TABLE public.concepto_liquidacion;

CREATE TABLE public.concepto_liquidacion
(
  idconcepto_liquidacion serial NOT NULL ,
  descripcion character(100) NOT NULL,
  codigo character(4),
  CONSTRAINT concepto_liquidacion_pkey PRIMARY KEY (idconcepto_liquidacion)
)
WITH (
  OIDS=FALSE
);

-- Index: public.idx_codigo_concepto

-- DROP INDEX public.idx_codigo_concepto;

CREATE UNIQUE INDEX idx_codigo_concepto
  ON public.concepto_liquidacion
  USING btree
  (codigo COLLATE pg_catalog."default");



ALTER TABLE public.cabecera_cuota_societaria DROP CONSTRAINT cabecera_cuota_societaria_idconcepto_liquidacion_fkey;

ALTER TABLE public.cabecera_cuota_societaria
  ADD CONSTRAINT cabecera_cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;



      ALTER TABLE public.cuota_societaria DROP CONSTRAINT cuota_societaria_idconcepto_liquidacion_fkey;

ALTER TABLE public.cuota_societaria
  ADD CONSTRAINT cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;


-- Table: public.cabecera_cuota_societaria

-- DROP TABLE public.cabecera_cuota_societaria;

CREATE TABLE public.cabecera_cuota_societaria
(
  idcabecera_cuota_societaria SERIAL NOT NULL ,
  archivo bytea NOT NULL,
  periodo character(7),
  fecha_importacion date,
  idconcepto_liquidacion integer,
  CONSTRAINT cabecera_cuota_societaria_pkey PRIMARY KEY (idcabecera_cuota_societaria),
  CONSTRAINT cabecera_cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);


-- Index: public.idx_periodo

-- DROP INDEX public.idx_periodo;

CREATE UNIQUE INDEX idx_periodo
  ON public.cabecera_cuota_societaria
  USING btree
  (periodo COLLATE pg_catalog."default");


-- Table: public.cuota_societaria

-- DROP TABLE public.cuota_societaria;

CREATE TABLE public.cuota_societaria
(
  idcuota_societaria SERIAL NOT NULL  ,
  idpersona integer NOT NULL,
  idafiliacion integer NOT NULL,
  cargo character(6) NOT NULL,
  idconcepto_liquidacion integer NOT NULL,
  monto double precision NOT NULL,
  idcabecera_cuota_societaria integer,
  CONSTRAINT cuota_societaria_pkey PRIMARY KEY (idcuota_societaria),
  CONSTRAINT cuota_societaria_idafiliacion_fkey FOREIGN KEY (idafiliacion, idpersona)
      REFERENCES public.afiliacion (idafiliacion, idpersona) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT cuota_societaria_idcabecera_cuota_societaria_fkey FOREIGN KEY (idcabecera_cuota_societaria)
      REFERENCES public.cabecera_cuota_societaria (idcabecera_cuota_societaria) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);


