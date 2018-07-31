ALTER TABLE public.detalle_consumo_financiado ADD COLUMN fecha date;
-- Function: public.generar_deuda_consumo_financiado()

-- DROP FUNCTION public.generar_deuda_consumo_financiado();

CREATE OR REPLACE FUNCTION public.generar_deuda_consumo_financiado()
  RETURNS trigger AS
$BODY$
DECLARE
    inicio integer := 0;
    fin integer := New.cantidad_cuotas;
    monto double precision := new.total / fin;
    fecha_cuota date:=New.fecha;
BEGIN
    
   LOOP
   
   EXIT WHEN inicio > fin ;
    INSERT INTO public.detalle_consumo_financiado( idconsumo_financiado, nro_cuota, mes, anio, monto, fecha)
    VALUES ( New.idconsumo_financiado, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)), extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), monto, (fecha_cuota + (inicio||' months')::interval)::date);
    inicio:=inicio+1;
    
    
  END LOOP;
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.generar_deuda_consumo_financiado()
  OWNER TO postgres;



-- Trigger: generar_numeros_talonario on public.talonario_bono

-- DROP TRIGGER generar_numeros_talonario ON public.talonario_bono;

CREATE TRIGGER generar_deuda_consumo_financiado
  AFTER INSERT
  ON public.consumo_financiado
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_deuda_consumo_financiado();

  
ALTER TABLE public.configuracion ADD COLUMN limite_por_socio double precision;

ALTER TABLE public.convenio ADD COLUMN permite_renovacion boolean;
ALTER TABLE public.convenio ALTER COLUMN permite_renovacion SET DEFAULT false;
