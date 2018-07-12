ALTER TABLE public.forma_pago ADD COLUMN planilla boolean;
ALTER TABLE public.forma_pago ALTER COLUMN planilla SET DEFAULT false;

ALTER TABLE public.concepto ADD COLUMN senia boolean;
ALTER TABLE public.concepto ALTER COLUMN senia SET DEFAULT false;
