
CREATE OR REPLACE FUNCTION public.telefonos_del_colono(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    telefonos text;
BEGIN
    FOR REG IN (SELECT  tipo_telefono.descripcion ||' Nro :'||nro_telefono||' | Referencia: '|| parentesco.descripcion as telefono
    FROM public.telefono_inscripcion_colono
    inner join tipo_telefono using(idtipo_telefono)
    inner join parentesco using(idparentesco)
    where
    telefono_inscripcion_colono.idinscripcion_colono =$1) 
  LOOP
      telefonos:=  coalesce(telefonos,'') ||' | '||coalesce(reg.telefono,'');

       
    END LOOP;
   RETURN telefonos;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;



-- Function: public.premios_del_bono_colaboracion(integer)

-- DROP FUNCTION public.premios_del_bono_colaboracion(integer);

CREATE OR REPLACE FUNCTION public.premios_del_bono_colaboracion(integer)
  RETURNS text AS
$BODY$
DECLARE
    reg RECORD;
    premios text;
BEGIN
    FOR REG IN (SELECT 'Nro :'||nro_premio||' - '||descripcion as premio
        FROM public.premio_sorteo
        where
        idtalonario_bono_colaboracion  =$1) 
  LOOP
      premios:=  coalesce(premios,'') ||' | '||coalesce(reg.premio,'');

       
    END LOOP;
   RETURN premios;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.premios_del_bono_colaboracion(integer)
  OWNER TO postgres;


-- Function: public.cantidad_numeros_vendidos_talonario_bono_colaboracion(integer)


CREATE OR REPLACE FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer)
  RETURNS integer AS
$BODY$
DECLARE
    cantidad integer;
    
BEGIN
  cantidad := (SELECT count(*) as cantidad FROM public.talonario_nros_bono_colaboracion
      where
      idtalonario_bono_colaboracion = $1 );
      
   RETURN cantidad;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

