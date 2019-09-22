-- Function: public.f_validar_sesion(character varying, character varying)

-- DROP FUNCTION public.f_validar_sesion(character varying, character varying);

CREATE OR REPLACE FUNCTION public.f_validar_sesion(
    IN p_email character varying,
    IN p_clave character varying)
  RETURNS TABLE(estado integer, dato character varying, usuario character varying) AS
$BODY$
	declare
		v_registro record;-- almacena un recurso
		v_respuesta character varying;
		v_estado int;
	begin
		begin
			Select 
				u.dni_usuario,
				u.estado,
				u.clave,
				(p.nombres || ' ' || p.apellido_paterno || ' ' || p.apellido_materno):: varchar as nombre
			into
				v_registro
				
			from 	usuario u
			
				inner join personal p on (u.dni_usuario = p.dni)
				
			where 
					p.email = p_email;

			v_estado = 500; ---error;

			if FOUND then
					if v_registro.clave = md5(p_clave) then
					
						if v_registro.estado = 'I' then
						
							v_respuesta = 'Usuario inactivo';

						else
							v_estado = 200;
							v_respuesta = v_registro.dni_usuario;
							
						end if;
						
					else
						v_respuesta = 'Clave incorrecta';
						
					end if;
					
			else
					v_respuesta = 'El ususario no existe';
			end if;
			
		EXCEPTION
			when others then
				RAISE EXCEPTION '%', SQLERRM;
		end;
		if v_estado = 200 then
			return query select v_estado, v_respuesta,v_registro.nombre;
		else
			return query select v_estado, v_respuesta,'-'::varchar;
		end if;
		
		
	end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION public.f_validar_sesion(character varying, character varying)
  OWNER TO urfmrhoiteekto;

  select * from f_validar_sesion('hmera@usat.edu.pe','456');
