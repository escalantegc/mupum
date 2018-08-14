DROP TRIGGER generar_deuda_consumo_convenio_cuotas ON public.consumo_convenio;

CREATE TRIGGER generar_deuda_consumo_convenio_cuotas
  AFTER INSERT 
  ON public.consumo_convenio
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_deuda_consumo_convenio_cuotas();

UPDATE public.talonario_nros_bono SET  disponible=true, idafiliacion=null;


CREATE UNIQUE INDEX idx_convenio_ayuda_economica_activo
  ON public.convenio
  USING btree
  (ayuda_economica, activo)
  WHERE ayuda_economica = true AND activo = true;
