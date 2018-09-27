-- Table: public.temporada_pileta

-- DROP TABLE public.temporada_pileta;

CREATE TABLE public.temporada_pileta
(
  idtemporada_pileta serial NOT NULL ,
  descripcion character(100) NOT NULL,
  fecha_inicio date NOT NULL,
  fecha_fin date NOT NULL,
  CONSTRAINT temporada_pileta_pkey PRIMARY KEY (idtemporada_pileta)
)
WITH (
  OIDS=FALSE
);

CREATE UNIQUE INDEX idx_temporada_pileta
  ON public.temporada_pileta
  USING btree
  (descripcion COLLATE pg_catalog."default");

-- Table: public.costo_pileta_tipo_socio

-- DROP TABLE public.costo_pileta_tipo_socio;

CREATE TABLE public.costo_pileta_tipo_socio
(
  idcosto_pileta_tipo_socio serial NOT NULL,
  idtemporada_pileta integer NOT NULL,
  idtipo_socio integer NOT NULL,
  costo_grupo_familiar double precision NOT NULL,
  costo_cetificado_medico double precision NOT NULL,
  CONSTRAINT costo_pileta_tipo_socio_pkey PRIMARY KEY (idcosto_pileta_tipo_socio),
  CONSTRAINT costo_pileta_tipo_socio_idtemporada_pileta_fkey FOREIGN KEY (idtemporada_pileta)
      REFERENCES public.temporada_pileta (idtemporada_pileta) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT costo_pileta_tipo_socio_idtipo_socio_fkey FOREIGN KEY (idtipo_socio)
      REFERENCES public.tipo_socio (idtipo_socio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.costo_pileta_tipo_socio
  OWNER TO postgres;


-- Table: public.inscripcion_pileta

-- DROP TABLE public.inscripcion_pileta;

CREATE TABLE public.inscripcion_pileta
(
  idinscripcion_pileta serial NOT NULL ,
  idtemporada_pileta integer NOT NULL,
  idafiliacion integer NOT NULL,
  costo_grupo_familiar double precision NOT NULL,
  CONSTRAINT inscripcion_pileta_pkey PRIMARY KEY (idinscripcion_pileta),
  CONSTRAINT inscripcion_pileta_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT inscripcion_pileta_idtemporada_pileta_fkey FOREIGN KEY (idtemporada_pileta)
      REFERENCES public.temporada_pileta (idtemporada_pileta) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.inscripcion_pileta
  OWNER TO postgres;

-- Index: public.inscripcion_pileta_idtemporada_pileta_idafiliacion_idx

-- DROP INDEX public.inscripcion_pileta_idtemporada_pileta_idafiliacion_idx;

CREATE INDEX inscripcion_pileta_idtemporada_pileta_idafiliacion_idx
  ON public.inscripcion_pileta
  USING btree
  (idtemporada_pileta, idafiliacion);


-- Table: public.detalle_inscripcion_pileta

-- DROP TABLE public.detalle_inscripcion_pileta;

CREATE TABLE public.detalle_inscripcion_pileta
(
  iddetalle_inscripcion_pileta serial NOT NULL,
  idinscripcion_pileta integer NOT NULL,
  idpersona_familia integer NOT NULL,
  observacion character(150),
  CONSTRAINT detalle_inscripcion_pileta_pkey PRIMARY KEY (iddetalle_inscripcion_pileta),
  CONSTRAINT detalle_inscripcion_pileta_idinscripcion_pileta_fkey FOREIGN KEY (idinscripcion_pileta)
      REFERENCES public.inscripcion_pileta (idinscripcion_pileta) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.detalle_inscripcion_pileta
  OWNER TO postgres;

-- Index: public.detalle_inscripcion_pileta_idpersona_familia_idx

-- DROP INDEX public.detalle_inscripcion_pileta_idpersona_familia_idx;

CREATE UNIQUE INDEX detalle_inscripcion_pileta_idpersona_familia_idx
  ON public.detalle_inscripcion_pileta
  USING btree
  (idpersona_familia);


-- Table: public.cabecera_liquidacion

-- DROP TABLE public.cabecera_liquidacion;

CREATE TABLE public.cabecera_liquidacion
(
  idcabecera_liquidacion serial NOT NULL ,
  idconcepto_liquidacion integer NOT NULL,
  periodo character(7) NOT NULL,
  fecha_liquidacion date NOT NULL,
  usuario character(50) NOT NULL,
  liquidado boolean DEFAULT false,
  exportado boolean DEFAULT false,
  conciliado boolean DEFAULT false,
  CONSTRAINT cabecera_liquidacion_pkey PRIMARY KEY (idcabecera_liquidacion),
  CONSTRAINT cabecera_liquidacion_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.cabecera_liquidacion
  OWNER TO postgres;


-- Table: public.detalle_liquidacion

-- DROP TABLE public.detalle_liquidacion;

CREATE TABLE public.detalle_liquidacion
(
  iddetalle_liquidacion serial NOT NULL ,
  idcabecera_liquidacion integer NOT NULL,
  idafiliacion integer NOT NULL,
  monto double precision NOT NULL,
  saldo double precision NOT NULL DEFAULT 0,
  CONSTRAINT detalle_liquidacion_pkey PRIMARY KEY (iddetalle_liquidacion),
  CONSTRAINT detalle_liquidacion_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT detalle_liquidacion_idcabecera_liquidacion_fkey FOREIGN KEY (idcabecera_liquidacion)
      REFERENCES public.cabecera_liquidacion (idcabecera_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.detalle_liquidacion
  OWNER TO postgres;
