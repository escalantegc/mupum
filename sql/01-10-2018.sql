ALTER TABLE public.inscripcion_pileta ADD COLUMN adicional_mayores_edad double precision;
ALTER TABLE public.inscripcion_pileta ALTER COLUMN adicional_mayores_edad SET DEFAULT 0;


ALTER TABLE public.costo_pileta_tipo_socio ADD COLUMN adicional_mayores_edad double precision;
ALTER TABLE public.costo_pileta_tipo_socio ALTER COLUMN adicional_mayores_edad SET DEFAULT 0;


ALTER TABLE public.inscripcion_pileta ADD COLUMN total double precision;
ALTER TABLE public.inscripcion_pileta ALTER COLUMN total SET DEFAULT 0;

ALTER TABLE public.detalle_inscripcion_pileta ADD COLUMN costo_extra double precision;
ALTER TABLE public.detalle_inscripcion_pileta ALTER COLUMN costo_extra SET DEFAULT 0;


-- Table: public.detalle_pago

-- DROP TABLE public.detalle_pago;

CREATE TABLE public.detalle_pago_inscripcion_pileta
(
  iddetalle_pago_inscripcion_pileta serial NOT NULL ,
  monto double precision,
  idinscripcion_pileta integer,
  idforma_pago integer,
  idconcepto integer,
  descripcion character(50),
  fecha date,
  envio_descuento boolean DEFAULT false,
  CONSTRAINT detalle_pago_inscripcion_pileta_pkey PRIMARY KEY (iddetalle_pago_inscripcion_pileta),
  CONSTRAINT detalle_pago_inscripcion_pileta_idforma_pago_fkey FOREIGN KEY (idforma_pago)
      REFERENCES public.forma_pago (idforma_pago) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);


CREATE OR REPLACE FUNCTION public.familiar_de_un_titular(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    familiares text;
BEGIN
    FOR REG IN (SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||' - '||persona.nombres as titular,
                     parentesco.descripcion||': '||familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            inner join detalle_inscripcion_pileta on detalle_inscripcion_pileta.idpersona_familia= familia.idpersona_familia
            where
		persona.idpersona = $1) LOOP
  familiares:=  coalesce(familiares,'') ||' | '||coalesce(reg.familiar_titular,'');

       
    END LOOP;
   RETURN familiares;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


-- Table: public.cabecera_liquidacion

-- DROP TABLE public.cabecera_liquidacion;

CREATE TABLE public.cabecera_liquidacion
(
  idcabecera_liquidacion serial NOT NULL DEFAULT ,
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
stgres;
