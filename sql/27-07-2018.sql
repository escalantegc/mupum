

-- Table: public.talonario_nros_bono

-- DROP TABLE public.talonario_nros_bono;

CREATE TABLE public.talonario_nros_bono
(
  idtalonario_bono integer NOT NULL,
  nro_bono integer NOT NULL,
  disponible boolean DEFAULT true,
  idafiliacion integer,
  CONSTRAINT nros_talonorio_bono_pkey PRIMARY KEY (idtalonario_bono, nro_bono),
  CONSTRAINT nros_talonorio_bono_idtalonario_bono_fkey FOREIGN KEY (idtalonario_bono)
      REFERENCES public.talonario_bono (idtalonario_bono) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.talonario_nros_bono
  OWNER TO postgres;


-- Trigger: generar_numeros_talonario on public.talonario_bono

-- DROP TRIGGER generar_numeros_talonario ON public.talonario_bono;

CREATE TRIGGER generar_numeros_talonario
  AFTER INSERT
  ON public.talonario_bono
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_numeros_talonario();

-- Function: public.generar_numeros_talonario()

-- DROP FUNCTION public.generar_numeros_talonario();
-- Function: public.generar_numeros_talonario()

-- DROP FUNCTION public.generar_numeros_talonario();

CREATE OR REPLACE FUNCTION public.generar_numeros_talonario()
  RETURNS trigger AS
$BODY$
DECLARE
    inicio integer := New.nro_inicio;
    fin integer := New.nro_fin;
BEGIN
    
	 LOOP
	 EXIT WHEN inicio > fin ;
		INSERT INTO public.talonario_nros_bono(idtalonario_bono, nro_bono)
		VALUES (New.idtalonario_bono,inicio);
		inicio:=inicio+1;
		
		
	END LOOP;
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.generar_numeros_talonario()
  OWNER TO postgres;
