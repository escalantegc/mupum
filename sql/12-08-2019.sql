-- Function: public.familiar_de_un_titular(integer)

-- DROP FUNCTION public.familiar_de_un_titular(integer);

CREATE OR REPLACE FUNCTION public.traer_apellido_nombres_persona(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    familiar text;
BEGIN
     familiar:= (SELECT     persona.apellido ||', '||persona.nombres as persona
                 

            FROM 
                    persona
            where
		persona.idpersona = $1);

  
   RETURN familiar;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

