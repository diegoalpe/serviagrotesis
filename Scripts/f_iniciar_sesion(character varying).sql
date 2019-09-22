
CREATE OR REPLACE FUNCTION public.f_iniciar_sesion
(
p_email character varying,
p_clave character varying
)
  RETURNS CHARACTER AS
$BODY$
	
	begin
		begin
		EXCEPTION
		when others then
			RAISE EXCEPTION '%', SQLERRM;
	end
	return '?';
	
$BODY$
  LANGUAGE plpgsql;
