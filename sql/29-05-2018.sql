-- Sequence: public.persona_idpersona_seq

-- DROP SEQUENCE public.persona_idpersona_seq;

CREATE SEQUENCE public.persona_idpersona_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE public.persona_idpersona_seq
  OWNER TO postgres;

ALTER TABLE public.persona ALTER COLUMN idpersona SET DEFAULT nextval('persona_idpersona_seq'::regclass);


-- Sequence: public.provincia_idprovincia_seq

-- DROP SEQUENCE public.provincia_idprovincia_seq;

CREATE SEQUENCE public.provincia_idprovincia_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE public.provincia_idprovincia_seq
  OWNER TO postgres;

ALTER TABLE public.provincia ALTER COLUMN idprovincia SET DEFAULT nextval('provincia_idprovincia_seq'::regclass);

