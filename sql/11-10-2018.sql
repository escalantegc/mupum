ALTER TABLE public.telefono_inscripcion_colono DROP CONSTRAINT telefono_inscripcion_colono_idinscripcion_colono_fkey;

ALTER TABLE public.telefono_inscripcion_colono
  ADD CONSTRAINT telefono_inscripcion_colono_idinscripcion_colono_fkey FOREIGN KEY (idinscripcion_colono)
      REFERENCES public.inscripcion_colono (idinscripcion_colono) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;
