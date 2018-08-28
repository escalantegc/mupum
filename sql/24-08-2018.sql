-- Table: public.configuracion_bolsita

-- DROP TABLE public.configuracion_bolsita;

CREATE TABLE public.configuracion_bolsita
(
  idconfiguracion_bolsita serial NOT NULL ,
  anio integer NOT NULL,
  inicio date NOT NULL,
  fin date NOT NULL,
  CONSTRAINT configuracion_bolsita_pkey PRIMARY KEY (idconfiguracion_bolsita)
)
WITH (
  OIDS=FALSE
);


 DROP TABLE public.bolsita_escolar


CREATE UNIQUE INDEX idx_anio
  ON public.configuracion_bolsita
  USING btree
  (anio);


 -- Table: public.nivel

-- DROP TABLE public.nivel;

CREATE TABLE public.nivel
(
  idnivel serial NOT NULL ,
  descripcion character(50) NOT NULL,
  edad_minima integer NOT NULL,
  edad_maxima integer,
  es_bolsita boolean DEFAULT false,
  CONSTRAINT nivel_pkey PRIMARY KEY (idnivel)
)
WITH (
  OIDS=FALSE
);
CREATE UNIQUE INDEX idx_nivel
  ON public.nivel
  USING btree
  (descripcion COLLATE pg_catalog."default");

-- Table: public.solicitud_bolsita

-- DROP TABLE public.solicitud_bolsita;

CREATE TABLE public.solicitud_bolsita
(
  idsolicitud_bolsita serial NOT NULL DEFAULT ,
  idpersona_familia integer NOT NULL,
  fecha_solicitud date NOT NULL,
  idnivel integer NOT NULL,
  observacion text,
  fecha_entrega date,
  entregado boolean,
  idconfiguracion_bolsita integer NOT NULL,
  fecha_rechazo date,
  CONSTRAINT solicitud_bolsita_pkey PRIMARY KEY (idsolicitud_bolsita),
  CONSTRAINT solicitud_bolsita_idconfiguracion_bolsita_fkey FOREIGN KEY (idconfiguracion_bolsita)
      REFERENCES public.configuracion_bolsita (idconfiguracion_bolsita) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT solicitud_bolsita_idnivel_fkey FOREIGN KEY (idnivel)
      REFERENCES public.nivel (idnivel) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);

-- Index: public.idx_solicitud_bolsita

-- DROP INDEX public.idx_solicitud_bolsita;

CREATE UNIQUE INDEX idx_solicitud_bolsita
  ON public.solicitud_bolsita
  USING btree
  (idconfiguracion_bolsita, idpersona_familia);




-- Index: public.idx_solicitud_bolsita

-- DROP INDEX public.idx_solicitud_bolsita;

CREATE UNIQUE INDEX idx_solicitud_bolsita
  ON public.solicitud_bolsita
  USING btree
  (idconfiguracion_bolsita, idpersona_familia);




-- Table: public.tipo_subsidio

-- DROP TABLE public.tipo_subsidio;

CREATE TABLE public.tipo_subsidio
(
  idtipo_subsidio serial NOT NULL ,
  descripcion character(50) NOT NULL,
  limite integer NOT NULL,
  monto double precision NOT NULL,
  CONSTRAINT tipo_subsidio_pkey PRIMARY KEY (idtipo_subsidio)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.tipo_subsidio
  OWNER TO postgres;

-- Table: public.solicitud_subsidio

-- DROP TABLE public.solicitud_subsidio;

CREATE TABLE public.solicitud_subsidio
(
  idsolicitud_subsidio serial NOT NULL ,
  idafiliacion integer NOT NULL,
  idtipo_subsidio integer NOT NULL,
  fecha_solicitud date,
  fecha_pago date,
  monto double precision,
  observacion text,
  pagado boolean,
  CONSTRAINT solicitud_subsidio_pkey PRIMARY KEY (idsolicitud_subsidio),
  CONSTRAINT solicitud_subsidio_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT solicitud_subsidio_idtipo_subsidio_fkey FOREIGN KEY (idtipo_subsidio)
      REFERENCES public.tipo_subsidio (idtipo_subsidio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.solicitud_subsidio
  OWNER TO postgres;
