-- Table: public.talonario_bono_colaboracion

-- DROP TABLE public.talonario_bono_colaboracion;

CREATE TABLE public.talonario_bono_colaboracion
(
  idtalonario_bono_colaboracion serial NOT NULL ,
  descripcion character(100) NOT NULL,
  nro_talonario integer,
  nro_inicio integer NOT NULL,
  nro_fin integer NOT NULL,
  fecha_sorteo date NOT NULL,
  monto double precision NOT NULL,
  CONSTRAINT talonario_bono_colaboracion_pkey PRIMARY KEY (idtalonario_bono_colaboracion)
)
WITH (
  OIDS=FALSE
);


-- Table: public.talonario_nros_bono_colaboracion

-- DROP TABLE public.talonario_nros_bono_colaboracion;

CREATE TABLE public.talonario_nros_bono_colaboracion
(
  idtalonario_bono_colaboracion integer NOT NULL,
  nro_bono integer NOT NULL,
  disponible boolean DEFAULT true,
  idafiliacion integer,
  idpersona_externa integer,
  fecha_compra date,
  idforma_pago integer NOT NULL,
  pagado boolean DEFAULT false,
  persona_externa boolean DEFAULT false,
  CONSTRAINT talonario_nros_bono_colaboracion_pkey PRIMARY KEY (idtalonario_bono_colaboracion, nro_bono),
  CONSTRAINT talonario_nros_bono_colaborac_idtalonario_bono_colaboracio_fkey FOREIGN KEY (idtalonario_bono_colaboracion)
      REFERENCES public.talonario_bono_colaboracion (idtalonario_bono_colaboracion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT talonario_nros_bono_colaboracion_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT talonario_nros_bono_colaboracion_idpersona_externa_fkey FOREIGN KEY (idpersona_externa)
      REFERENCES public.persona (idpersona) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);



-- Function: public.generar_numeros_talonario()

-- DROP FUNCTION public.generar_numeros_talonario();

CREATE OR REPLACE FUNCTION public.generar_numeros_talonario_bono_colaboracion()
  RETURNS trigger AS
$BODY$
DECLARE
    inicio integer := New.nro_inicio;
    fin integer := New.nro_fin;
BEGIN
    
  LOOP
  EXIT WHEN inicio > fin ;
  INSERT INTO public.talonario_nros_bono_colaboracion(idtalonario_bono_colaboracion, nro_bono,idforma_pago)
VALUES (New.idtalonario_bono_colaboracion,inicio, (select idforma_pago from forma_pago where planilla=true));
  inicio:=inicio+1;
  
  
 END LOOP;
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


-- Trigger: generar_numeros_talonario_bono_colaboracion on public.talonario_bono_colaboracion

-- DROP TRIGGER generar_numeros_talonario_bono_colaboracion ON public.talonario_bono_colaboracion;

CREATE TRIGGER generar_numeros_talonario_bono_colaboracion
  AFTER INSERT
  ON public.talonario_bono_colaboracion
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_numeros_talonario_bono_colaboracion();







-- Function: public.generar_numeros_talonario_bono_colaboracion()

-- DROP FUNCTION public.generar_numeros_talonario_bono_colaboracion();

CREATE OR REPLACE FUNCTION public.cantidad_numeros_vendidos_talonario_bono_colaboracion(integer)
  RETURNS integer AS
$BODY$
DECLARE
    cantidad integer;
    
BEGIN
  cantidad := (SELECT count(*) as cantidad FROM public.talonario_nros_bono_colaboracion
      where
      idtalonario_bono_colaboracion = $1 and
      pagado = true);
      
   RETURN cantidad;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
