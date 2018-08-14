DROP TRIGGER generar_deuda_consumo_convenio_cuotas ON public.consumo_convenio;

CREATE TRIGGER generar_deuda_consumo_convenio_cuotas
  AFTER INSERT 
  ON public.consumo_convenio
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_deuda_consumo_convenio_cuotas();

UPDATE public.talonario_nros_bono SET  disponible=true, idafiliacion=null;
