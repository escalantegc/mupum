--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.12
-- Dumped by pg_dump version 9.5.12

-- Started on 2018-05-28 20:27:53 -03

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 1 (class 3079 OID 12435)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2429 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 217 (class 1259 OID 60360)
-- Name: afiliacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.afiliacion (
    idafiliacion integer NOT NULL,
    idpersona integer NOT NULL,
    idtipo_socio integer NOT NULL,
    idestado integer NOT NULL,
    fecha_solicitud date,
    fecha_alta date,
    fecha_baja date,
    activa boolean DEFAULT false NOT NULL
);


ALTER TABLE public.afiliacion OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 60358)
-- Name: afiliacion_idafiliacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.afiliacion_idafiliacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.afiliacion_idafiliacion_seq OWNER TO postgres;

--
-- TOC entry 2430 (class 0 OID 0)
-- Dependencies: 216
-- Name: afiliacion_idafiliacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.afiliacion_idafiliacion_seq OWNED BY public.afiliacion.idafiliacion;


--
-- TOC entry 213 (class 1259 OID 60344)
-- Name: bolsita_escolar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bolsita_escolar (
    idpersona integer NOT NULL,
    idpersona_familia integer NOT NULL,
    idparentesco integer NOT NULL,
    idnivel_estudio integer NOT NULL,
    anio character varying NOT NULL,
    idestado integer NOT NULL
);


ALTER TABLE public.bolsita_escolar OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 60279)
-- Name: categoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria (
    idcategoria integer NOT NULL,
    descripcion character varying(100) NOT NULL,
    monto_permitido double precision NOT NULL
);


ALTER TABLE public.categoria OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 60209)
-- Name: categoria_estado; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria_estado (
    idcategoria_estado integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.categoria_estado OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 60207)
-- Name: categoria_estado_idcategoria_estado_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_estado_idcategoria_estado_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_estado_idcategoria_estado_seq OWNER TO postgres;

--
-- TOC entry 2431 (class 0 OID 0)
-- Dependencies: 181
-- Name: categoria_estado_idcategoria_estado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_estado_idcategoria_estado_seq OWNED BY public.categoria_estado.idcategoria_estado;


--
-- TOC entry 198 (class 1259 OID 60277)
-- Name: categoria_idcategoria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_idcategoria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_idcategoria_seq OWNER TO postgres;

--
-- TOC entry 2432 (class 0 OID 0)
-- Dependencies: 198
-- Name: categoria_idcategoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_idcategoria_seq OWNED BY public.categoria.idcategoria;


--
-- TOC entry 186 (class 1259 OID 60226)
-- Name: categoria_motivo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria_motivo (
    idcategoria_motivo integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.categoria_motivo OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 60224)
-- Name: categoria_motivo_idcategoria_motivo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_motivo_idcategoria_motivo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_motivo_idcategoria_motivo_seq OWNER TO postgres;

--
-- TOC entry 2433 (class 0 OID 0)
-- Dependencies: 185
-- Name: categoria_motivo_idcategoria_motivo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_motivo_idcategoria_motivo_seq OWNED BY public.categoria_motivo.idcategoria_motivo;


--
-- TOC entry 203 (class 1259 OID 60295)
-- Name: comercio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.comercio (
    idcomercio integer NOT NULL,
    nombre character varying(100) NOT NULL,
    direccion character varying(100) NOT NULL,
    idlocalidad integer NOT NULL
);


ALTER TABLE public.comercio OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 60293)
-- Name: comercio_idcomercio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.comercio_idcomercio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comercio_idcomercio_seq OWNER TO postgres;

--
-- TOC entry 2434 (class 0 OID 0)
-- Dependencies: 202
-- Name: comercio_idcomercio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.comercio_idcomercio_seq OWNED BY public.comercio.idcomercio;


--
-- TOC entry 184 (class 1259 OID 60221)
-- Name: configuracion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.configuracion (
    edad_maxima_bolsita_escolar integer NOT NULL,
    dias_confirmacion_reserva integer NOT NULL
);


ALTER TABLE public.configuracion OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 60301)
-- Name: convenio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.convenio (
    idcategoria integer NOT NULL,
    idcomercio integer NOT NULL,
    monto_permitido double precision NOT NULL,
    fecha_alta date NOT NULL,
    fecha_baja date
);


ALTER TABLE public.convenio OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 60258)
-- Name: estado; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estado (
    idestado integer NOT NULL,
    descripcion character varying(50) NOT NULL,
    idcategoria_estado integer NOT NULL
);


ALTER TABLE public.estado OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 70034)
-- Name: estado_civil; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estado_civil (
    idestado_civil integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.estado_civil OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 70032)
-- Name: estado_civil_idestado_civil_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.estado_civil_idestado_civil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estado_civil_idestado_civil_seq OWNER TO postgres;

--
-- TOC entry 2435 (class 0 OID 0)
-- Dependencies: 218
-- Name: estado_civil_idestado_civil_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.estado_civil_idestado_civil_seq OWNED BY public.estado_civil.idestado_civil;


--
-- TOC entry 193 (class 1259 OID 60256)
-- Name: estado_idestado_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.estado_idestado_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estado_idestado_seq OWNER TO postgres;

--
-- TOC entry 2436 (class 0 OID 0)
-- Dependencies: 193
-- Name: estado_idestado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.estado_idestado_seq OWNED BY public.estado.idestado;


--
-- TOC entry 212 (class 1259 OID 60339)
-- Name: familia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.familia (
    idpersona integer NOT NULL,
    idpersona_familia integer NOT NULL,
    idparentesco integer NOT NULL,
    fecha_relacion date NOT NULL
);


ALTER TABLE public.familia OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 60266)
-- Name: instalacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.instalacion (
    idinstalacion integer NOT NULL,
    nombre character varying(50) NOT NULL,
    cantidad_maxima_personas integer NOT NULL
);


ALTER TABLE public.instalacion OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 60264)
-- Name: instalacion_idinstalacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.instalacion_idinstalacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.instalacion_idinstalacion_seq OWNER TO postgres;

--
-- TOC entry 2437 (class 0 OID 0)
-- Dependencies: 195
-- Name: instalacion_idinstalacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.instalacion_idinstalacion_seq OWNED BY public.instalacion.idinstalacion;


--
-- TOC entry 201 (class 1259 OID 60287)
-- Name: localidad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.localidad (
    idlocalidad integer NOT NULL,
    idprovincia integer NOT NULL,
    descripcion character varying(100) NOT NULL
);


ALTER TABLE public.localidad OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 60285)
-- Name: localidad_idlocalidad_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.localidad_idlocalidad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.localidad_idlocalidad_seq OWNER TO postgres;

--
-- TOC entry 2438 (class 0 OID 0)
-- Dependencies: 200
-- Name: localidad_idlocalidad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.localidad_idlocalidad_seq OWNED BY public.localidad.idlocalidad;


--
-- TOC entry 188 (class 1259 OID 60234)
-- Name: motivo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motivo (
    idmotivo integer NOT NULL,
    idcategoria_motivo integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.motivo OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 60232)
-- Name: motivo_idmotivo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.motivo_idmotivo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.motivo_idmotivo_seq OWNER TO postgres;

--
-- TOC entry 2439 (class 0 OID 0)
-- Dependencies: 187
-- Name: motivo_idmotivo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.motivo_idmotivo_seq OWNED BY public.motivo.idmotivo;


--
-- TOC entry 183 (class 1259 OID 60215)
-- Name: nivel_estudio_idnivel_estudio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nivel_estudio_idnivel_estudio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.nivel_estudio_idnivel_estudio_seq OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 60242)
-- Name: pais; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pais (
    idpais integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.pais OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 60240)
-- Name: pais_idpais_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pais_idpais_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pais_idpais_seq OWNER TO postgres;

--
-- TOC entry 2440 (class 0 OID 0)
-- Dependencies: 189
-- Name: pais_idpais_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pais_idpais_seq OWNED BY public.pais.idpais;


--
-- TOC entry 206 (class 1259 OID 60308)
-- Name: parentesco; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parentesco (
    idparentesco integer NOT NULL,
    descripcion character varying(50) NOT NULL,
    bolsita_escolar boolean DEFAULT false NOT NULL
);


ALTER TABLE public.parentesco OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 60306)
-- Name: parentesco_idparentesco_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.parentesco_idparentesco_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parentesco_idparentesco_seq OWNER TO postgres;

--
-- TOC entry 2441 (class 0 OID 0)
-- Dependencies: 205
-- Name: parentesco_idparentesco_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.parentesco_idparentesco_seq OWNED BY public.parentesco.idparentesco;


--
-- TOC entry 209 (class 1259 OID 60323)
-- Name: persona; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.persona (
    idpersona integer NOT NULL,
    idtipo_documento integer NOT NULL,
    nro_documento character varying(9) NOT NULL,
    cuil character varying(11),
    legajo character varying(6),
    apellido character varying(50) NOT NULL,
    nombres character varying(100) NOT NULL,
    correo character varying(100),
    cbu character varying(22),
    fecha_nacimiento date,
    idlocalidad integer NOT NULL,
    calle character varying(50),
    altura character varying(6),
    piso character varying(2),
    depto character varying(2),
    idestado_civil integer
);


ALTER TABLE public.persona OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 60272)
-- Name: provincia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.provincia (
    idprovincia integer NOT NULL,
    descripcion character varying(50) NOT NULL,
    idpais integer NOT NULL
);


ALTER TABLE public.provincia OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 60333)
-- Name: solicitud_reserva; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.solicitud_reserva (
    idsolicitud_reserva integer NOT NULL,
    idpersona integer NOT NULL,
    fecha date NOT NULL,
    idinstalacion integer NOT NULL,
    idestado integer NOT NULL,
    idmotivo integer NOT NULL,
    nro_personas integer NOT NULL
);


ALTER TABLE public.solicitud_reserva OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 60331)
-- Name: solicitud_reserva_idsolicitud_reserva_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.solicitud_reserva_idsolicitud_reserva_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.solicitud_reserva_idsolicitud_reserva_seq OWNER TO postgres;

--
-- TOC entry 2442 (class 0 OID 0)
-- Dependencies: 210
-- Name: solicitud_reserva_idsolicitud_reserva_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.solicitud_reserva_idsolicitud_reserva_seq OWNED BY public.solicitud_reserva.idsolicitud_reserva;


--
-- TOC entry 220 (class 1259 OID 70089)
-- Name: telefono_por_persona; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.telefono_por_persona (
    idtipo_telefono integer NOT NULL,
    idpersona integer NOT NULL,
    nro_telefono character(10) NOT NULL
);


ALTER TABLE public.telefono_por_persona OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 60317)
-- Name: tipo_documento; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_documento (
    idtipo_documento integer NOT NULL,
    sigla character varying(10) NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.tipo_documento OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 60315)
-- Name: tipo_documento_idtipo_documento_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_documento_idtipo_documento_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_documento_idtipo_documento_seq OWNER TO postgres;

--
-- TOC entry 2443 (class 0 OID 0)
-- Dependencies: 207
-- Name: tipo_documento_idtipo_documento_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_documento_idtipo_documento_seq OWNED BY public.tipo_documento.idtipo_documento;


--
-- TOC entry 215 (class 1259 OID 60352)
-- Name: tipo_socio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_socio (
    idtipo_socio integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.tipo_socio OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 60350)
-- Name: tipo_socio_idtipo_socio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_socio_idtipo_socio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_socio_idtipo_socio_seq OWNER TO postgres;

--
-- TOC entry 2444 (class 0 OID 0)
-- Dependencies: 214
-- Name: tipo_socio_idtipo_socio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_socio_idtipo_socio_seq OWNED BY public.tipo_socio.idtipo_socio;


--
-- TOC entry 192 (class 1259 OID 60250)
-- Name: tipo_telefono; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_telefono (
    idtipo_telefono integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.tipo_telefono OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 60248)
-- Name: tipo_telefono_idtipo_telefono_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_telefono_idtipo_telefono_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_telefono_idtipo_telefono_seq OWNER TO postgres;

--
-- TOC entry 2445 (class 0 OID 0)
-- Dependencies: 191
-- Name: tipo_telefono_idtipo_telefono_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_telefono_idtipo_telefono_seq OWNED BY public.tipo_telefono.idtipo_telefono;


--
-- TOC entry 2195 (class 2604 OID 60363)
-- Name: idafiliacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.afiliacion ALTER COLUMN idafiliacion SET DEFAULT nextval('public.afiliacion_idafiliacion_seq'::regclass);


--
-- TOC entry 2187 (class 2604 OID 60282)
-- Name: idcategoria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria ALTER COLUMN idcategoria SET DEFAULT nextval('public.categoria_idcategoria_seq'::regclass);


--
-- TOC entry 2180 (class 2604 OID 60212)
-- Name: idcategoria_estado; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_estado ALTER COLUMN idcategoria_estado SET DEFAULT nextval('public.categoria_estado_idcategoria_estado_seq'::regclass);


--
-- TOC entry 2181 (class 2604 OID 60229)
-- Name: idcategoria_motivo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_motivo ALTER COLUMN idcategoria_motivo SET DEFAULT nextval('public.categoria_motivo_idcategoria_motivo_seq'::regclass);


--
-- TOC entry 2189 (class 2604 OID 60298)
-- Name: idcomercio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comercio ALTER COLUMN idcomercio SET DEFAULT nextval('public.comercio_idcomercio_seq'::regclass);


--
-- TOC entry 2185 (class 2604 OID 60261)
-- Name: idestado; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado ALTER COLUMN idestado SET DEFAULT nextval('public.estado_idestado_seq'::regclass);


--
-- TOC entry 2197 (class 2604 OID 70037)
-- Name: idestado_civil; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado_civil ALTER COLUMN idestado_civil SET DEFAULT nextval('public.estado_civil_idestado_civil_seq'::regclass);


--
-- TOC entry 2186 (class 2604 OID 60269)
-- Name: idinstalacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instalacion ALTER COLUMN idinstalacion SET DEFAULT nextval('public.instalacion_idinstalacion_seq'::regclass);


--
-- TOC entry 2188 (class 2604 OID 60290)
-- Name: idlocalidad; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.localidad ALTER COLUMN idlocalidad SET DEFAULT nextval('public.localidad_idlocalidad_seq'::regclass);


--
-- TOC entry 2182 (class 2604 OID 60237)
-- Name: idmotivo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo ALTER COLUMN idmotivo SET DEFAULT nextval('public.motivo_idmotivo_seq'::regclass);


--
-- TOC entry 2183 (class 2604 OID 60245)
-- Name: idpais; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pais ALTER COLUMN idpais SET DEFAULT nextval('public.pais_idpais_seq'::regclass);


--
-- TOC entry 2190 (class 2604 OID 60311)
-- Name: idparentesco; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parentesco ALTER COLUMN idparentesco SET DEFAULT nextval('public.parentesco_idparentesco_seq'::regclass);


--
-- TOC entry 2193 (class 2604 OID 60336)
-- Name: idsolicitud_reserva; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reserva ALTER COLUMN idsolicitud_reserva SET DEFAULT nextval('public.solicitud_reserva_idsolicitud_reserva_seq'::regclass);


--
-- TOC entry 2192 (class 2604 OID 60320)
-- Name: idtipo_documento; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_documento ALTER COLUMN idtipo_documento SET DEFAULT nextval('public.tipo_documento_idtipo_documento_seq'::regclass);


--
-- TOC entry 2194 (class 2604 OID 60355)
-- Name: idtipo_socio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_socio ALTER COLUMN idtipo_socio SET DEFAULT nextval('public.tipo_socio_idtipo_socio_seq'::regclass);


--
-- TOC entry 2184 (class 2604 OID 60253)
-- Name: idtipo_telefono; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_telefono ALTER COLUMN idtipo_telefono SET DEFAULT nextval('public.tipo_telefono_idtipo_telefono_seq'::regclass);


--
-- TOC entry 2417 (class 0 OID 60360)
-- Dependencies: 217
-- Data for Name: afiliacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.afiliacion (idafiliacion, idpersona, idtipo_socio, idestado, fecha_solicitud, fecha_alta, fecha_baja, activa) FROM stdin;
\.


--
-- TOC entry 2446 (class 0 OID 0)
-- Dependencies: 216
-- Name: afiliacion_idafiliacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.afiliacion_idafiliacion_seq', 1, false);


--
-- TOC entry 2413 (class 0 OID 60344)
-- Dependencies: 213
-- Data for Name: bolsita_escolar; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bolsita_escolar (idpersona, idpersona_familia, idparentesco, idnivel_estudio, anio, idestado) FROM stdin;
\.


--
-- TOC entry 2399 (class 0 OID 60279)
-- Dependencies: 199
-- Data for Name: categoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categoria (idcategoria, descripcion, monto_permitido) FROM stdin;
\.


--
-- TOC entry 2382 (class 0 OID 60209)
-- Dependencies: 182
-- Data for Name: categoria_estado; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categoria_estado (idcategoria_estado, descripcion) FROM stdin;
\.


--
-- TOC entry 2447 (class 0 OID 0)
-- Dependencies: 181
-- Name: categoria_estado_idcategoria_estado_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categoria_estado_idcategoria_estado_seq', 1, false);


--
-- TOC entry 2448 (class 0 OID 0)
-- Dependencies: 198
-- Name: categoria_idcategoria_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categoria_idcategoria_seq', 1, false);


--
-- TOC entry 2386 (class 0 OID 60226)
-- Dependencies: 186
-- Data for Name: categoria_motivo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categoria_motivo (idcategoria_motivo, descripcion) FROM stdin;
\.


--
-- TOC entry 2449 (class 0 OID 0)
-- Dependencies: 185
-- Name: categoria_motivo_idcategoria_motivo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categoria_motivo_idcategoria_motivo_seq', 1, false);


--
-- TOC entry 2403 (class 0 OID 60295)
-- Dependencies: 203
-- Data for Name: comercio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.comercio (idcomercio, nombre, direccion, idlocalidad) FROM stdin;
\.


--
-- TOC entry 2450 (class 0 OID 0)
-- Dependencies: 202
-- Name: comercio_idcomercio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.comercio_idcomercio_seq', 1, false);


--
-- TOC entry 2384 (class 0 OID 60221)
-- Dependencies: 184
-- Data for Name: configuracion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.configuracion (edad_maxima_bolsita_escolar, dias_confirmacion_reserva) FROM stdin;
\.


--
-- TOC entry 2404 (class 0 OID 60301)
-- Dependencies: 204
-- Data for Name: convenio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.convenio (idcategoria, idcomercio, monto_permitido, fecha_alta, fecha_baja) FROM stdin;
\.


--
-- TOC entry 2394 (class 0 OID 60258)
-- Dependencies: 194
-- Data for Name: estado; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.estado (idestado, descripcion, idcategoria_estado) FROM stdin;
\.


--
-- TOC entry 2419 (class 0 OID 70034)
-- Dependencies: 219
-- Data for Name: estado_civil; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.estado_civil (idestado_civil, descripcion) FROM stdin;
1	SOLTERO
2	CASADO
\.


--
-- TOC entry 2451 (class 0 OID 0)
-- Dependencies: 218
-- Name: estado_civil_idestado_civil_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.estado_civil_idestado_civil_seq', 6, true);


--
-- TOC entry 2452 (class 0 OID 0)
-- Dependencies: 193
-- Name: estado_idestado_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.estado_idestado_seq', 1, false);


--
-- TOC entry 2412 (class 0 OID 60339)
-- Dependencies: 212
-- Data for Name: familia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.familia (idpersona, idpersona_familia, idparentesco, fecha_relacion) FROM stdin;
\.


--
-- TOC entry 2396 (class 0 OID 60266)
-- Dependencies: 196
-- Data for Name: instalacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.instalacion (idinstalacion, nombre, cantidad_maxima_personas) FROM stdin;
\.


--
-- TOC entry 2453 (class 0 OID 0)
-- Dependencies: 195
-- Name: instalacion_idinstalacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.instalacion_idinstalacion_seq', 1, false);


--
-- TOC entry 2401 (class 0 OID 60287)
-- Dependencies: 201
-- Data for Name: localidad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.localidad (idlocalidad, idprovincia, descripcion) FROM stdin;
\.


--
-- TOC entry 2454 (class 0 OID 0)
-- Dependencies: 200
-- Name: localidad_idlocalidad_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.localidad_idlocalidad_seq', 1, false);


--
-- TOC entry 2388 (class 0 OID 60234)
-- Dependencies: 188
-- Data for Name: motivo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motivo (idmotivo, idcategoria_motivo, descripcion) FROM stdin;
\.


--
-- TOC entry 2455 (class 0 OID 0)
-- Dependencies: 187
-- Name: motivo_idmotivo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.motivo_idmotivo_seq', 1, false);


--
-- TOC entry 2456 (class 0 OID 0)
-- Dependencies: 183
-- Name: nivel_estudio_idnivel_estudio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nivel_estudio_idnivel_estudio_seq', 1, false);


--
-- TOC entry 2390 (class 0 OID 60242)
-- Dependencies: 190
-- Data for Name: pais; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pais (idpais, descripcion) FROM stdin;
\.


--
-- TOC entry 2457 (class 0 OID 0)
-- Dependencies: 189
-- Name: pais_idpais_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pais_idpais_seq', 1, false);


--
-- TOC entry 2406 (class 0 OID 60308)
-- Dependencies: 206
-- Data for Name: parentesco; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.parentesco (idparentesco, descripcion, bolsita_escolar) FROM stdin;
\.


--
-- TOC entry 2458 (class 0 OID 0)
-- Dependencies: 205
-- Name: parentesco_idparentesco_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.parentesco_idparentesco_seq', 1, false);


--
-- TOC entry 2409 (class 0 OID 60323)
-- Dependencies: 209
-- Data for Name: persona; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.persona (idpersona, idtipo_documento, nro_documento, cuil, legajo, apellido, nombres, correo, cbu, fecha_nacimiento, idlocalidad, calle, altura, piso, depto, idestado_civil) FROM stdin;
\.


--
-- TOC entry 2397 (class 0 OID 60272)
-- Dependencies: 197
-- Data for Name: provincia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.provincia (idprovincia, descripcion, idpais) FROM stdin;
\.


--
-- TOC entry 2411 (class 0 OID 60333)
-- Dependencies: 211
-- Data for Name: solicitud_reserva; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.solicitud_reserva (idsolicitud_reserva, idpersona, fecha, idinstalacion, idestado, idmotivo, nro_personas) FROM stdin;
\.


--
-- TOC entry 2459 (class 0 OID 0)
-- Dependencies: 210
-- Name: solicitud_reserva_idsolicitud_reserva_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.solicitud_reserva_idsolicitud_reserva_seq', 1, false);


--
-- TOC entry 2420 (class 0 OID 70089)
-- Dependencies: 220
-- Data for Name: telefono_por_persona; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.telefono_por_persona (idtipo_telefono, idpersona, nro_telefono) FROM stdin;
\.


--
-- TOC entry 2408 (class 0 OID 60317)
-- Dependencies: 208
-- Data for Name: tipo_documento; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tipo_documento (idtipo_documento, sigla, descripcion) FROM stdin;
1	DNI	DOCUMENTO NACIONAL DE IDENTIDAD
\.


--
-- TOC entry 2460 (class 0 OID 0)
-- Dependencies: 207
-- Name: tipo_documento_idtipo_documento_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_documento_idtipo_documento_seq', 2, true);


--
-- TOC entry 2415 (class 0 OID 60352)
-- Dependencies: 215
-- Data for Name: tipo_socio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tipo_socio (idtipo_socio, descripcion) FROM stdin;
1	TITULAR
4	JUBILIDADO
\.


--
-- TOC entry 2461 (class 0 OID 0)
-- Dependencies: 214
-- Name: tipo_socio_idtipo_socio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_socio_idtipo_socio_seq', 5, true);


--
-- TOC entry 2392 (class 0 OID 60250)
-- Dependencies: 192
-- Data for Name: tipo_telefono; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tipo_telefono (idtipo_telefono, descripcion) FROM stdin;
\.


--
-- TOC entry 2462 (class 0 OID 0)
-- Dependencies: 191
-- Name: tipo_telefono_idtipo_telefono_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_telefono_idtipo_telefono_seq', 1, false);


--
-- TOC entry 2247 (class 2606 OID 60366)
-- Name: idafiliacion; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.afiliacion
    ADD CONSTRAINT idafiliacion PRIMARY KEY (idafiliacion);


--
-- TOC entry 2221 (class 2606 OID 60284)
-- Name: idcategoria; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria
    ADD CONSTRAINT idcategoria PRIMARY KEY (idcategoria);


--
-- TOC entry 2199 (class 2606 OID 60214)
-- Name: idcategoria_estado; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_estado
    ADD CONSTRAINT idcategoria_estado PRIMARY KEY (idcategoria_estado);


--
-- TOC entry 2202 (class 2606 OID 60231)
-- Name: idcategoria_motivo; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_motivo
    ADD CONSTRAINT idcategoria_motivo PRIMARY KEY (idcategoria_motivo);


--
-- TOC entry 2226 (class 2606 OID 60300)
-- Name: idcomercion; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comercio
    ADD CONSTRAINT idcomercion PRIMARY KEY (idcomercio);


--
-- TOC entry 2228 (class 2606 OID 60305)
-- Name: idconvenio; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.convenio
    ADD CONSTRAINT idconvenio PRIMARY KEY (idcategoria, idcomercio);


--
-- TOC entry 2213 (class 2606 OID 60263)
-- Name: idestado; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado
    ADD CONSTRAINT idestado PRIMARY KEY (idestado);


--
-- TOC entry 2250 (class 2606 OID 70039)
-- Name: idestado_civil; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado_civil
    ADD CONSTRAINT idestado_civil PRIMARY KEY (idestado_civil);


--
-- TOC entry 2242 (class 2606 OID 60343)
-- Name: idfamilia; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familia
    ADD CONSTRAINT idfamilia PRIMARY KEY (idpersona, idpersona_familia, idparentesco);


--
-- TOC entry 2216 (class 2606 OID 60271)
-- Name: idinstalacion; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instalacion
    ADD CONSTRAINT idinstalacion PRIMARY KEY (idinstalacion);


--
-- TOC entry 2223 (class 2606 OID 60292)
-- Name: idlocalidad; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.localidad
    ADD CONSTRAINT idlocalidad PRIMARY KEY (idlocalidad);


--
-- TOC entry 2205 (class 2606 OID 60239)
-- Name: idmotivo; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo
    ADD CONSTRAINT idmotivo PRIMARY KEY (idmotivo);


--
-- TOC entry 2207 (class 2606 OID 60247)
-- Name: idpais; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pais
    ADD CONSTRAINT idpais PRIMARY KEY (idpais);


--
-- TOC entry 2230 (class 2606 OID 60314)
-- Name: idparentesco; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parentesco
    ADD CONSTRAINT idparentesco PRIMARY KEY (idparentesco);


--
-- TOC entry 2236 (class 2606 OID 60327)
-- Name: idpersona; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT idpersona PRIMARY KEY (idpersona);


--
-- TOC entry 2218 (class 2606 OID 60276)
-- Name: idprovincia; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provincia
    ADD CONSTRAINT idprovincia PRIMARY KEY (idprovincia);


--
-- TOC entry 2240 (class 2606 OID 60338)
-- Name: idsolicitud_reserva; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reserva
    ADD CONSTRAINT idsolicitud_reserva PRIMARY KEY (idsolicitud_reserva);


--
-- TOC entry 2233 (class 2606 OID 60322)
-- Name: idtipo_documento; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_documento
    ADD CONSTRAINT idtipo_documento PRIMARY KEY (idtipo_documento);


--
-- TOC entry 2244 (class 2606 OID 60357)
-- Name: idtipo_socio; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_socio
    ADD CONSTRAINT idtipo_socio PRIMARY KEY (idtipo_socio);


--
-- TOC entry 2210 (class 2606 OID 60255)
-- Name: idtipo_telefono; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_telefono
    ADD CONSTRAINT idtipo_telefono PRIMARY KEY (idtipo_telefono);


--
-- TOC entry 2253 (class 2606 OID 70103)
-- Name: telefono_por_persona_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono_por_persona
    ADD CONSTRAINT telefono_por_persona_pkey PRIMARY KEY (idtipo_telefono, idpersona, nro_telefono);


--
-- TOC entry 2248 (class 1259 OID 70073)
-- Name: idx_afiliacion; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_afiliacion ON public.afiliacion USING btree (idpersona, idtipo_socio) WHERE (activa = false);


--
-- TOC entry 2200 (class 1259 OID 70074)
-- Name: idx_categoria_estado; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_categoria_estado ON public.categoria_estado USING btree (descripcion);


--
-- TOC entry 2203 (class 1259 OID 70075)
-- Name: idx_categoria_motivo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_categoria_motivo ON public.categoria_motivo USING btree (descripcion);


--
-- TOC entry 2237 (class 1259 OID 70056)
-- Name: idx_documento; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_documento ON public.persona USING btree (idtipo_documento, nro_documento);


--
-- TOC entry 2214 (class 1259 OID 70076)
-- Name: idx_estado; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_estado ON public.estado USING btree (descripcion);


--
-- TOC entry 2251 (class 1259 OID 70040)
-- Name: idx_estado_civil; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_estado_civil ON public.estado_civil USING btree (descripcion);


--
-- TOC entry 2238 (class 1259 OID 70057)
-- Name: idx_legajo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_legajo ON public.persona USING btree (legajo);


--
-- TOC entry 2224 (class 1259 OID 70077)
-- Name: idx_localidad; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_localidad ON public.localidad USING btree (descripcion);


--
-- TOC entry 2208 (class 1259 OID 70078)
-- Name: idx_pais; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_pais ON public.pais USING btree (descripcion);


--
-- TOC entry 2231 (class 1259 OID 70079)
-- Name: idx_parentesco; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_parentesco ON public.parentesco USING btree (descripcion);


--
-- TOC entry 2219 (class 1259 OID 70080)
-- Name: idx_provincia; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_provincia ON public.provincia USING btree (descripcion);


--
-- TOC entry 2234 (class 1259 OID 70081)
-- Name: idx_tipo_documento; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_tipo_documento ON public.tipo_documento USING btree (sigla);


--
-- TOC entry 2245 (class 1259 OID 70104)
-- Name: idx_tipo_socio; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_tipo_socio ON public.tipo_socio USING btree (descripcion);


--
-- TOC entry 2211 (class 1259 OID 70083)
-- Name: idx_tipo_telefono; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_tipo_telefono ON public.tipo_telefono USING btree (descripcion);


--
-- TOC entry 2255 (class 2606 OID 60368)
-- Name: categoria_estado_estado_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado
    ADD CONSTRAINT categoria_estado_estado_fk FOREIGN KEY (idcategoria_estado) REFERENCES public.categoria_estado(idcategoria_estado);


--
-- TOC entry 2254 (class 2606 OID 60373)
-- Name: categoria_motivo_motivo_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo
    ADD CONSTRAINT categoria_motivo_motivo_fk FOREIGN KEY (idcategoria_motivo) REFERENCES public.categoria_motivo(idcategoria_motivo);


--
-- TOC entry 2262 (class 2606 OID 70068)
-- Name: familia_idparentesco_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familia
    ADD CONSTRAINT familia_idparentesco_fkey FOREIGN KEY (idparentesco) REFERENCES public.parentesco(idparentesco) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2263 (class 2606 OID 70063)
-- Name: familia_idpersona_familia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familia
    ADD CONSTRAINT familia_idpersona_familia_fkey FOREIGN KEY (idpersona_familia) REFERENCES public.persona(idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2264 (class 2606 OID 70058)
-- Name: familia_idpersona_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familia
    ADD CONSTRAINT familia_idpersona_fkey FOREIGN KEY (idpersona) REFERENCES public.persona(idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2257 (class 2606 OID 70084)
-- Name: localidad_idprovincia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.localidad
    ADD CONSTRAINT localidad_idprovincia_fkey FOREIGN KEY (idprovincia) REFERENCES public.provincia(idprovincia) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2261 (class 2606 OID 60378)
-- Name: motivo_solicitud_reserva_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reserva
    ADD CONSTRAINT motivo_solicitud_reserva_fk FOREIGN KEY (idmotivo) REFERENCES public.motivo(idmotivo);


--
-- TOC entry 2256 (class 2606 OID 60383)
-- Name: pais_provincia_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provincia
    ADD CONSTRAINT pais_provincia_fk FOREIGN KEY (idpais) REFERENCES public.pais(idpais);


--
-- TOC entry 2260 (class 2606 OID 70041)
-- Name: persona_idestado_civil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_idestado_civil_fkey FOREIGN KEY (idestado_civil) REFERENCES public.estado_civil(idestado_civil) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2259 (class 2606 OID 70046)
-- Name: persona_idlocalidad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_idlocalidad_fkey FOREIGN KEY (idlocalidad) REFERENCES public.localidad(idlocalidad) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2258 (class 2606 OID 70051)
-- Name: persona_idtipo_documento_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_idtipo_documento_fkey FOREIGN KEY (idtipo_documento) REFERENCES public.tipo_documento(idtipo_documento) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2265 (class 2606 OID 70097)
-- Name: telefono_por_persona_idpersona_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono_por_persona
    ADD CONSTRAINT telefono_por_persona_idpersona_fkey FOREIGN KEY (idpersona) REFERENCES public.persona(idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2266 (class 2606 OID 70092)
-- Name: telefono_por_persona_idtipo_telefono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono_por_persona
    ADD CONSTRAINT telefono_por_persona_idtipo_telefono_fkey FOREIGN KEY (idtipo_telefono) REFERENCES public.tipo_telefono(idtipo_telefono) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2428 (class 0 OID 0)
-- Dependencies: 6
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2018-05-28 20:27:54 -03

--
-- PostgreSQL database dump complete
--

