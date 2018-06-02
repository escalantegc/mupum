ALTER TABLE public.persona ADD COLUMN sexo character(1);
ALTER TABLE public.familia ADD COLUMN acargo boolean;
ALTER TABLE public.familia ALTER COLUMN acargo SET DEFAULT false;

