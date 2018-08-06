ALTER TABLE public.convenio ADD COLUMN faltando_cuotas integer;
ALTER TABLE public.comercios_por_convenio ADD COLUMN porcentaje_interes double precision;
ALTER TABLE public.comercios_por_convenio ADD COLUMN porcentaje_descuento double precision;
