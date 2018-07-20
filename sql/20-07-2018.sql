ALTER TABLE public.convenio ADD COLUMN consumo_ticket boolean;
ALTER TABLE public.convenio ALTER COLUMN consumo_ticket SET DEFAULT false;
