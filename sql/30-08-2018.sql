ALTER TABLE public.parentesco ADD COLUMN colonia boolean;
ALTER TABLE public.parentesco ALTER COLUMN colonia SET DEFAULT false;

CREATE TABLE public.configuracion_colonia
(
  idconfiguracion_colonia serial NOT NULL,
  anio integer NOT NULL,
  inicio date NOT NULL,
  fin date NOT NULL,
  inicio_inscripcion date NOT NULL,
  fin_inscripcion date NOT NULL,
  
  CONSTRAINT configuracion_colonia_pkey PRIMARY KEY (idconfiguracion_colonia)
)
WITH (
  OIDS=FALSE
);

-- Table: public.inscripcion_colono

-- DROP TABLE public.inscripcion_colono;

CREATE TABLE public.inscripcion_colono
(
  idinscripcion_colono serial NOT NULL ,
  idconfiguracion_colonia integer NOT NULL,
  idpersona_familia integer NOT NULL,
  es_alergico boolean NOT NULL DEFAULT false,
  alergias text,
  informacion_complementaria text,
  idafiliacion integer NOT NULL,
  fecha date,
  CONSTRAINT inscripcion_colono_pkey PRIMARY KEY (idinscripcion_colono),
  CONSTRAINT inscripcion_colono_idconfiguracion_colonia_fkey FOREIGN KEY (idconfiguracion_colonia)
      REFERENCES public.configuracion_colonia (idconfiguracion_colonia) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.inscripcion_colono
  OWNER TO postgres;



-- Table: public.telefono_inscripcion_colono

-- DROP TABLE public.telefono_inscripcion_colono;

CREATE TABLE public.telefono_inscripcion_colono
(
  idtipo_telefono integer NOT NULL,
  idinscripcion_colono integer NOT NULL,
  nro_telefono character(10) NOT NULL,
  CONSTRAINT telefono_inscripcion_colono_idinscripcion_colono_fkey FOREIGN KEY (idinscripcion_colono)
      REFERENCES public.inscripcion_colono (idinscripcion_colono) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT telefono_inscripcion_colono_idtipo_telefono_fkey FOREIGN KEY (idtipo_telefono)
      REFERENCES public.tipo_telefono (idtipo_telefono) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);


-- Table: public.costo_colonia_tipo_socio
-- DROP TABLE public.costo_colonia_tipo_socio;

CREATE TABLE public.costo_colonia_tipo_socio
(
  idcosto_colonia_tipo_socio serial NOT NULL ,
  idconfiguracion_colonia integer NOT NULL,
  idtipo_socio integer NOT NULL,
  monto double precision NOT NULL,
  porcentaje_inscripcion double precision NOT NULL,
  CONSTRAINT costo_colonia_tipo_socio_pkey PRIMARY KEY (idcosto_colonia_tipo_socio)
)
WITH (
  OIDS=FALSE
);