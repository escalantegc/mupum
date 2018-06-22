ALTER TABLE public.familia ADD COLUMN baja boolean;
ALTER TABLE public.familia ALTER COLUMN baja SET DEFAULT false;

ALTER TABLE public.familia ADD COLUMN fecha_baja date;
