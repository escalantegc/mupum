ALTER TABLE public.tipo_socio ADD COLUMN externo boolean;
ALTER TABLE public.tipo_socio ALTER COLUMN externo SET DEFAULT false;
