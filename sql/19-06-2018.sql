ALTER TABLE public.configuracion ADD COLUMN minimo_meses_afiliacion integer;
ALTER TABLE public.configuracion ALTER COLUMN minimo_meses_afiliacion SET NOT NULL;

ALTER TABLE public.configuracion ADD COLUMN idconfiguracion serial;
ALTER TABLE public.configuracion ALTER COLUMN idconfiguracion SET NOT NULL;
