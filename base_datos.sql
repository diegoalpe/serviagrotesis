
CREATE TABLE public.provincia
(
  codigo_departamento character(2) NOT NULL,
  codigo_provincia character(2) NOT NULL,
  nombre character varying(500) NOT NULL,
  CONSTRAINT pk_provincia PRIMARY KEY (codigo_departamento, codigo_provincia),
  CONSTRAINT fk_provincia_departamento FOREIGN KEY (codigo_departamento)
      REFERENCES public.departamento (codigo_departamento)
);


CREATE TABLE cultivo(
 codigo_agricultor Integer NOT NULL,
 codigo_cultivo Integer NOT NULL,
 nombre Character varying(50) NOT NULL,
 semilla Character varying(50) NOT NULL,
 constraint pk_cultivo primary key (codigo_cultivo),
 constraint fk_cultivo_agricultor foreign key (codigo_agricultor) references public.agricultor (codigo_agricultor)    
);

CREATE TABLE tipo_nutriente(
 codigo_tipo_nutriente Integer NOT NULL,
 nombre Character varying(50) NOT NULL,
 constraint pk_tipo_nutriente primary key (codigo_tipo_nutriente)
);

CREATE TABLE nutriente(
 nombre Character varying(50) NOT NULL,
 codigo_nutriente Integer NOT NULL,
 codigo_tipo_nutriente Integer,
 constraint pk_nutriente primary key (codigo_nutriente),
 constraint fk_nutriente_tipo_nutriente foreign key (codigo_tipo_nutriente) references public.tipo_nutriente (codigo_tipo_nutriente) 
);


CREATE TABLE tipo_suelo(
 codigo_tipo_suelo Integer NOT NULL,
 nombre Character varying(50) NOT NULL,
 constraint pk_tipo_suelo primary key (codigo_tipo_suelo)
);

CREATE TABLE suelo(
 codigo_cultivo Integer NOT NULL,
 ubicacion Character varying(50) NOT NULL,
 descripcion Character varying(200),
 area Numeric(14,2) NOT NULL,
 codigo_tipo_suelo Integer,
 codigo_nutriente Integer,
 constraint pk_suelo primary key (codigo_cultivo, codigo_nutriente),
 constraint pk_suelo_cultivo foreign key (codigo_cultivo) references public.cultivo (codigo_cultivo),
 constraint pk_suelo_nutriente foreign key (codigo_nutriente) references public.nutriente (codigo_nutriente)
);


CREATE TABLE tipo_fertilizante(
 codigo_tipo_fertilizante Integer NOT NULL,
 nombre Character varying(50) NOT NULL,
 constraint pk_tipo_fertilizante primary key (codigo_tipo_fertilizante)
);

CREATE TABLE fertilizante(
 codigo_fertilizante Integer NOT NULL,
 nombre Character varying(50) NOT NULL,
 composicion Numeric(14,2) NOT NULL,
 componente Character varying(20),
 descripcion Character varying(500),
 codigo_tipo_fertilizante Integer,
 constraint pk_fertilizante primary key (codigo_fertilizante),
 constraint fk_fertilizante_tipo_fertilizante foreign key (codigo_tipo_fertilizante) references public.tipo_fertilizante (codigo_tipo_fertilizante)
);