--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.1
-- Dumped by pg_dump version 9.6.12

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: iris; Type: DATABASE; Schema: -; Owner: iris
--

CREATE DATABASE iris WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'pt_BR.UTF-8' LC_CTYPE = 'pt_BR.UTF-8';


ALTER DATABASE iris OWNER TO iris;

\connect iris

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: breakpoint; Type: TYPE; Schema: public; Owner: iris
--

CREATE TYPE public.breakpoint AS (
	func oid,
	linenumber integer,
	targetname text
);


ALTER TYPE public.breakpoint OWNER TO iris;

--
-- Name: dblink_pkey_results; Type: TYPE; Schema: public; Owner: iris
--

CREATE TYPE public.dblink_pkey_results AS (
	"position" integer,
	colname text
);


ALTER TYPE public.dblink_pkey_results OWNER TO iris;

--
-- Name: frame; Type: TYPE; Schema: public; Owner: iris
--

CREATE TYPE public.frame AS (
	level integer,
	targetname text,
	func oid,
	linenumber integer,
	args text
);


ALTER TYPE public.frame OWNER TO iris;

--
-- Name: proxyinfo; Type: TYPE; Schema: public; Owner: iris
--

CREATE TYPE public.proxyinfo AS (
	serverversionstr text,
	serverversionnum integer,
	proxyapiver integer,
	serverprocessid integer
);


ALTER TYPE public.proxyinfo OWNER TO iris;

--
-- Name: targetinfo; Type: TYPE; Schema: public; Owner: iris
--

CREATE TYPE public.targetinfo AS (
	target oid,
	schema oid,
	nargs integer,
	argtypes oidvector,
	targetname name,
	argmodes "char"[],
	argnames text[],
	targetlang oid,
	fqname text,
	returnsset boolean,
	returntype oid
);


ALTER TYPE public.targetinfo OWNER TO iris;

--
-- Name: var; Type: TYPE; Schema: public; Owner: iris
--

CREATE TYPE public.var AS (
	name text,
	varclass character(1),
	linenumber integer,
	isunique boolean,
	isconst boolean,
	isnotnull boolean,
	dtype oid,
	value text
);


ALTER TYPE public.var OWNER TO iris;

--
-- Name: xpath_list(text, text); Type: FUNCTION; Schema: public; Owner: iris
--

CREATE FUNCTION public.xpath_list(text, text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT xpath_list($1,$2,',')$_$;


ALTER FUNCTION public.xpath_list(text, text) OWNER TO iris;

--
-- Name: xpath_nodeset(text, text); Type: FUNCTION; Schema: public; Owner: iris
--

CREATE FUNCTION public.xpath_nodeset(text, text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT xpath_nodeset($1,$2,'','')$_$;


ALTER FUNCTION public.xpath_nodeset(text, text) OWNER TO iris;

--
-- Name: xpath_nodeset(text, text, text); Type: FUNCTION; Schema: public; Owner: iris
--

CREATE FUNCTION public.xpath_nodeset(text, text, text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT xpath_nodeset($1,$2,'',$3)$_$;


ALTER FUNCTION public.xpath_nodeset(text, text, text) OWNER TO iris;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: alertas; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.alertas (
    id_alerta bigint NOT NULL,
    tabela integer,
    dias integer,
    mensagem character varying,
    titulo character varying,
    opcao1 character varying,
    opcao2 character varying,
    id_usuario bigint
);


ALTER TABLE public.alertas OWNER TO iris;

--
-- Name: alertas_id_alerta_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.alertas_id_alerta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.alertas_id_alerta_seq OWNER TO iris;

--
-- Name: alertas_id_alerta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iris
--

ALTER SEQUENCE public.alertas_id_alerta_seq OWNED BY public.alertas.id_alerta;


--
-- Name: aluno_estagio; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.aluno_estagio (
    id_aluno_estagio bigint NOT NULL,
    matricula character varying(7) NOT NULL,
    id_curso bigint NOT NULL,
    horas_necessarias integer,
    meses_necessarios integer,
    tipo character(1)
);


ALTER TABLE public.aluno_estagio OWNER TO iris;

--
-- Name: TABLE aluno_estagio; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON TABLE public.aluno_estagio IS 'sem essa tabela, se o administrador alterar a quantidade de horas de estagio necessarias, irá "estragar" o estágio de alunos que concluiram estagio anteriormente';


--
-- Name: COLUMN aluno_estagio.tipo; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.aluno_estagio.tipo IS 'E=estagio

T=trabalho';


--
-- Name: aluno_estagio_aluno_estagio_id_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.aluno_estagio_aluno_estagio_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.aluno_estagio_aluno_estagio_id_seq OWNER TO iris;

--
-- Name: aluno_estagio_aluno_estagio_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iris
--

ALTER SEQUENCE public.aluno_estagio_aluno_estagio_id_seq OWNED BY public.aluno_estagio.id_aluno_estagio;


--
-- Name: coordenador_id_coordenador_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.coordenador_id_coordenador_seq
    START WITH 12
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.coordenador_id_coordenador_seq OWNER TO iris;

--
-- Name: coordenador; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.coordenador (
    id_cordenador bigint DEFAULT nextval('public.coordenador_id_coordenador_seq'::regclass) NOT NULL,
    id_usuario bigint NOT NULL,
    id_curso bigint NOT NULL,
    data_inicio date NOT NULL,
    data_final date NOT NULL,
    ativo boolean DEFAULT true,
    formacao text
);


ALTER TABLE public.coordenador OWNER TO iris;

--
-- Name: COLUMN coordenador.formacao; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.coordenador.formacao IS 'historico profissional do coordenador';


--
-- Name: cursos_id_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.cursos_id_seq
    START WITH 6
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cursos_id_seq OWNER TO iris;

--
-- Name: curso; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.curso (
    id_curso bigint DEFAULT nextval('public.cursos_id_seq'::regclass) NOT NULL,
    nome character varying(50),
    ano_minimo integer NOT NULL,
    ativo boolean DEFAULT true,
    semestre_minimo integer NOT NULL,
    codigo_curso character varying(2),
    media_curso integer,
    horas_estagio integer,
    meses_estagio integer,
    meses_trabalho integer,
    anos_estagio integer,
    ultimo_numero_aprovacao character varying(10)
);


ALTER TABLE public.curso OWNER TO iris;

--
-- Name: COLUMN curso.media_curso; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.curso.media_curso IS 'media minima de nota do curso (usa na finalizacao do estagio)';


--
-- Name: COLUMN curso.horas_estagio; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.curso.horas_estagio IS 'quantidade de horas de estagio necessarias';


--
-- Name: COLUMN curso.meses_estagio; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.curso.meses_estagio IS 'qtd de meses minimo de estagio';


--
-- Name: COLUMN curso.anos_estagio; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.curso.anos_estagio IS 'numero de anos apos a matricula que o aluno pode estagiar';


--
-- Name: empresa_id_empresa_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.empresa_id_empresa_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.empresa_id_empresa_seq OWNER TO iris;

--
-- Name: empresa; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.empresa (
    id_empresa bigint DEFAULT nextval('public.empresa_id_empresa_seq'::regclass) NOT NULL,
    razao_social character varying(100) NOT NULL,
    representante_legal character varying(50),
    cargo character varying(50),
    cnpj character varying(14) NOT NULL,
    insc_estadual character varying(50),
    endereco character varying(80),
    bairro character varying(50),
    cep character varying(8),
    caixa_postal character varying(4),
    cidade character varying(30),
    uf character varying(2),
    telefone character varying(8),
    fax character varying(10),
    email character varying(50),
    observacoes text,
    tipo_pessoa character(1),
    ddd character(2),
    ativo boolean DEFAULT true NOT NULL
);


ALTER TABLE public.empresa OWNER TO iris;

--
-- Name: COLUMN empresa.cnpj; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.empresa.cnpj IS 'cpf,cnpj,cgc';


--
-- Name: COLUMN empresa.tipo_pessoa; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.empresa.tipo_pessoa IS '"F"=física

"J"=jurídica';


--
-- Name: empresa_convenio; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.empresa_convenio (
    id_empresa_convenio bigint NOT NULL,
    id_empresa bigint NOT NULL,
    validade date NOT NULL,
    obs text,
    ativo boolean DEFAULT true
);


ALTER TABLE public.empresa_convenio OWNER TO iris;

--
-- Name: empresa_convenio_id_empresa_convenio_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.empresa_convenio_id_empresa_convenio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.empresa_convenio_id_empresa_convenio_seq OWNER TO iris;

--
-- Name: empresa_convenio_id_empresa_convenio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iris
--

ALTER SEQUENCE public.empresa_convenio_id_empresa_convenio_seq OWNED BY public.empresa_convenio.id_empresa_convenio;


--
-- Name: empresa_curso_id_empresa_curso_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.empresa_curso_id_empresa_curso_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.empresa_curso_id_empresa_curso_seq OWNER TO iris;

--
-- Name: empresa_curso; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.empresa_curso (
    id_empresa_curso integer DEFAULT nextval('public.empresa_curso_id_empresa_curso_seq'::regclass) NOT NULL,
    id_empresa bigint NOT NULL,
    id_curso bigint NOT NULL
);


ALTER TABLE public.empresa_curso OWNER TO iris;

SET default_with_oids = true;

--
-- Name: empresa_setor; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.empresa_setor (
    id_empresa integer,
    id_setor bigint NOT NULL
);


ALTER TABLE public.empresa_setor OWNER TO iris;

--
-- Name: empresa_setor_id_empresa_setor_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.empresa_setor_id_empresa_setor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.empresa_setor_id_empresa_setor_seq OWNER TO iris;

--
-- Name: estagio_id_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.estagio_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estagio_id_seq OWNER TO iris;

SET default_with_oids = false;

--
-- Name: estagio; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.estagio (
    id_estagio bigint DEFAULT nextval('public.estagio_id_seq'::regclass) NOT NULL,
    matricula_aluno character varying(7) NOT NULL,
    data_inicio date NOT NULL,
    id_empresa integer NOT NULL,
    situacao character(1) DEFAULT 'A'::bpchar,
    observacao text,
    id_supervisor integer NOT NULL,
    id_setor integer NOT NULL,
    id_curso integer NOT NULL,
    id_coordenador integer NOT NULL,
    horario_entrada time(0) without time zone,
    horario_saida time(0) without time zone,
    ativo boolean DEFAULT true NOT NULL,
    atividades text,
    motivo_cancelamento text,
    dias_semana integer,
    protocolo character varying(15),
    horario_entrada2 time without time zone,
    horario_saida2 time without time zone,
    data_plano date,
    max_conclusao date
);


ALTER TABLE public.estagio OWNER TO iris;

--
-- Name: COLUMN estagio.situacao; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.estagio.situacao IS '''A''=aberto

''F''=finalizado

''C''=cancelado

''I''=inválido (concluído mas não foi aceito)';


--
-- Name: COLUMN estagio.horario_entrada; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.estagio.horario_entrada IS 'horário de entrada do aluno no estágio';


--
-- Name: COLUMN estagio.horario_saida; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.estagio.horario_saida IS 'horario de saída do aluno do estágio';


--
-- Name: COLUMN estagio.atividades; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.estagio.atividades IS 'atividades que o estagiario desenvolve';


--
-- Name: COLUMN estagio.max_conclusao; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.estagio.max_conclusao IS 'data maxima que o aluno pode concluir esse estagio';


--
-- Name: estagio_adicao_id_estagio_adicao_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.estagio_adicao_id_estagio_adicao_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estagio_adicao_id_estagio_adicao_seq OWNER TO iris;

SET default_with_oids = true;

--
-- Name: estagio_adicao; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.estagio_adicao (
    id_estagio_adicao bigint DEFAULT nextval('public.estagio_adicao_id_estagio_adicao_seq'::regclass) NOT NULL,
    id_estagio bigint NOT NULL,
    data_final date NOT NULL,
    protocolo character varying(9),
    obs text,
    data_cadastro date DEFAULT ('now'::text)::date,
    data_termo date
);


ALTER TABLE public.estagio_adicao OWNER TO iris;

--
-- Name: COLUMN estagio_adicao.data_final; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.estagio_adicao.data_final IS 'nova data de vencimento do estágio';


--
-- Name: id_estagio_bimestral_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.id_estagio_bimestral_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_estagio_bimestral_seq OWNER TO iris;

SET default_with_oids = false;

--
-- Name: estagio_bimestral; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.estagio_bimestral (
    id_estagio integer,
    id_periodo integer,
    protocolo character varying(10),
    id_estagio_bimestral bigint DEFAULT nextval('public.id_estagio_bimestral_seq'::regclass) NOT NULL
);


ALTER TABLE public.estagio_bimestral OWNER TO iris;

--
-- Name: estagio_final_estagio_final_id_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.estagio_final_estagio_final_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estagio_final_estagio_final_id_seq OWNER TO iris;

--
-- Name: estagio_final; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.estagio_final (
    id_estagio_final bigint DEFAULT nextval('public.estagio_final_estagio_final_id_seq'::regclass) NOT NULL,
    data timestamp without time zone DEFAULT ('now'::text)::date,
    nota_i_a integer,
    nota_i_b integer,
    nota_i_c integer,
    nota_ii_a integer,
    nota_ii_b integer,
    nota_ii_c integer,
    nota_ii_d integer,
    nota_final numeric(5,2),
    id_estagio integer NOT NULL,
    horas_cumpridas integer,
    data_termino date,
    nota_iii_a integer,
    nota_iii_b integer,
    nota_iv_a integer,
    nota_iv_b integer,
    nota_iv_c integer,
    outras_inf text,
    data_relatorio date,
    numero_aprovacao character varying(10),
    id_coordenador bigint
);


ALTER TABLE public.estagio_final OWNER TO iris;

--
-- Name: estagio_historico_estagio_historico_id_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.estagio_historico_estagio_historico_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estagio_historico_estagio_historico_id_seq OWNER TO iris;

--
-- Name: grupo_id_grupo_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.grupo_id_grupo_seq
    START WITH 4
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupo_id_grupo_seq OWNER TO iris;

--
-- Name: grupo; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.grupo (
    id_grupo bigint DEFAULT nextval('public.grupo_id_grupo_seq'::regclass) NOT NULL,
    nome character varying(30) NOT NULL,
    descricao text,
    ativo boolean DEFAULT true,
    admin boolean DEFAULT false NOT NULL,
    restricao character varying(30)
);


ALTER TABLE public.grupo OWNER TO iris;

--
-- Name: historico_id_historico_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.historico_id_historico_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.historico_id_historico_seq OWNER TO iris;

--
-- Name: historico; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.historico (
    id_historico bigint DEFAULT nextval('public.historico_id_historico_seq'::regclass) NOT NULL,
    id_usuario bigint NOT NULL,
    tabela character varying(20),
    campo character varying(30),
    valor_antigo text,
    descricao character varying(10),
    data timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone,
    acao integer
);


ALTER TABLE public.historico OWNER TO iris;

--
-- Name: COLUMN historico.acao; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.historico.acao IS '1=inserção

2=edição

3=exclusão';


--
-- Name: parametros_id_parametro_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.parametros_id_parametro_seq
    START WITH 2
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parametros_id_parametro_seq OWNER TO iris;

--
-- Name: parametros; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.parametros (
    id_parametro integer DEFAULT nextval('public.parametros_id_parametro_seq'::regclass) NOT NULL,
    nome_instituicao character varying(60) NOT NULL,
    endereco_instituicao character varying(50),
    bairro_instituicao character varying(50),
    cidade_instituicao character varying(30),
    uf_instituicao character varying(2),
    cep_instituicao character varying(9),
    fone_instituicao character varying(9),
    email_sistema character varying(50) NOT NULL,
    ddd character(2),
    ramal character(5),
    alerta integer,
    fax_instituicao character varying(9),
    pais_instituicao character varying(20),
    relatorio_controle_intervalo integer DEFAULT 60,
    validade_convenio integer,
    ultimo_backup date,
    ultimo_numero_aprovacao character varying(10)
);


ALTER TABLE public.parametros OWNER TO iris;

--
-- Name: COLUMN parametros.email_sistema; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.parametros.email_sistema IS 'Email usado para envio de emails do sistema';


--
-- Name: COLUMN parametros.validade_convenio; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.parametros.validade_convenio IS 'quantidade de meses que dura o convênio das empresas';


--
-- Name: periodo_id_periodo_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.periodo_id_periodo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.periodo_id_periodo_seq OWNER TO iris;

--
-- Name: periodo; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.periodo (
    id_periodo integer DEFAULT nextval('public.periodo_id_periodo_seq'::regclass) NOT NULL,
    data_inicial date,
    data_final date,
    descricao character varying(50),
    concluido boolean DEFAULT false NOT NULL,
    ativo boolean DEFAULT true NOT NULL
);


ALTER TABLE public.periodo OWNER TO iris;

--
-- Name: representante_id_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.representante_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.representante_id_seq OWNER TO iris;

--
-- Name: setor_id_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.setor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.setor_id_seq OWNER TO iris;

SET default_with_oids = true;

--
-- Name: setor; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.setor (
    id_setor bigint DEFAULT nextval('public.setor_id_seq'::regclass) NOT NULL,
    nome character varying(50) NOT NULL,
    descricao text,
    ativo boolean DEFAULT true
);


ALTER TABLE public.setor OWNER TO iris;

--
-- Name: supervisor; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.supervisor (
    id_supervisor integer DEFAULT nextval('public.representante_id_seq'::regclass) NOT NULL,
    id_empresa integer NOT NULL,
    nome character varying(50),
    ddd character(2),
    telefone character varying(8),
    ramal character(5),
    email character varying(50),
    ativo boolean DEFAULT true
);


ALTER TABLE public.supervisor OWNER TO iris;

--
-- Name: trabalho_id_trabalho_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.trabalho_id_trabalho_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.trabalho_id_trabalho_seq OWNER TO iris;

--
-- Name: trabalho; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.trabalho (
    id_trabalho bigint DEFAULT nextval('public.trabalho_id_trabalho_seq'::regclass) NOT NULL,
    matricula_aluno character varying(7) NOT NULL,
    data_inicio date,
    data_final date,
    id_empresa integer,
    situacao character(1),
    observacao text,
    aluno_num_cpts character(11) NOT NULL,
    aluno_serie_cpts character(10) NOT NULL,
    protocolo character varying(6),
    id_supervisor integer,
    id_setor integer,
    id_coordenador integer,
    motivo_cancelamento character varying,
    data_plano date,
    data date DEFAULT ('now'::text)::date,
    ativo boolean DEFAULT true,
    numero_aprovacao character varying(10),
    id_curso integer
);


ALTER TABLE public.trabalho OWNER TO iris;

--
-- Name: COLUMN trabalho.situacao; Type: COMMENT; Schema: public; Owner: iris
--

COMMENT ON COLUMN public.trabalho.situacao IS '''A''=aberto

''F''=finalizado

''C''=cancelado

''I''=inválido (concluído mas não foi aceito)';


--
-- Name: usuario_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: iris
--

CREATE SEQUENCE public.usuario_id_usuario_seq
    START WITH 15
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_usuario_seq OWNER TO iris;

SET default_with_oids = false;

--
-- Name: usuario; Type: TABLE; Schema: public; Owner: iris
--

CREATE TABLE public.usuario (
    id_usuario integer DEFAULT nextval('public.usuario_id_usuario_seq'::regclass) NOT NULL,
    login character varying(20) NOT NULL,
    senha character varying(50) NOT NULL,
    nome character varying(20) NOT NULL,
    sobrenome character varying(50) NOT NULL,
    email character varying(50) NOT NULL,
    email2 character varying(50),
    rg character varying(10),
    cpf character varying(11),
    data_nasc date,
    telefone1 character varying(8),
    telefone2 character varying(8),
    endereco character varying(50),
    bairro character varying(50),
    cep character varying(8),
    cidade character varying(50),
    uf character varying(2),
    sexo character varying(1),
    ativo boolean DEFAULT true NOT NULL,
    id_grupo bigint NOT NULL,
    ddd1 character(2),
    ddd2 character(2)
);


ALTER TABLE public.usuario OWNER TO iris;

--
-- Name: alertas id_alerta; Type: DEFAULT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.alertas ALTER COLUMN id_alerta SET DEFAULT nextval('public.alertas_id_alerta_seq'::regclass);


--
-- Name: aluno_estagio id_aluno_estagio; Type: DEFAULT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.aluno_estagio ALTER COLUMN id_aluno_estagio SET DEFAULT nextval('public.aluno_estagio_aluno_estagio_id_seq'::regclass);


--
-- Name: empresa_convenio id_empresa_convenio; Type: DEFAULT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa_convenio ALTER COLUMN id_empresa_convenio SET DEFAULT nextval('public.empresa_convenio_id_empresa_convenio_seq'::regclass);


--
-- Name: alertas alertas_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.alertas
    ADD CONSTRAINT alertas_pkey PRIMARY KEY (id_alerta);


--
-- Name: aluno_estagio aluno_estagio_pk; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.aluno_estagio
    ADD CONSTRAINT aluno_estagio_pk PRIMARY KEY (id_aluno_estagio);


--
-- Name: coordenador coordenador_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.coordenador
    ADD CONSTRAINT coordenador_pkey PRIMARY KEY (id_cordenador);


--
-- Name: curso curso_pk; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.curso
    ADD CONSTRAINT curso_pk PRIMARY KEY (id_curso);


--
-- Name: empresa_convenio empresa_convenio_pk; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa_convenio
    ADD CONSTRAINT empresa_convenio_pk PRIMARY KEY (id_empresa_convenio);


--
-- Name: empresa_curso empresa_curso_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa_curso
    ADD CONSTRAINT empresa_curso_pkey PRIMARY KEY (id_empresa_curso);


--
-- Name: empresa empresa_pk; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa
    ADD CONSTRAINT empresa_pk PRIMARY KEY (id_empresa);


--
-- Name: supervisor empresa_reponsavel_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.supervisor
    ADD CONSTRAINT empresa_reponsavel_pkey PRIMARY KEY (id_supervisor);


--
-- Name: estagio_adicao estagio_adicao_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio_adicao
    ADD CONSTRAINT estagio_adicao_pkey PRIMARY KEY (id_estagio_adicao);


--
-- Name: estagio_final estagio_final_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio_final
    ADD CONSTRAINT estagio_final_pkey PRIMARY KEY (id_estagio_final);


--
-- Name: estagio estagio_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio
    ADD CONSTRAINT estagio_pkey PRIMARY KEY (id_estagio);


--
-- Name: grupo grupo_pk; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.grupo
    ADD CONSTRAINT grupo_pk PRIMARY KEY (id_grupo);


--
-- Name: historico historico_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.historico
    ADD CONSTRAINT historico_pkey PRIMARY KEY (id_historico);


--
-- Name: parametros parametros_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.parametros
    ADD CONSTRAINT parametros_pkey PRIMARY KEY (id_parametro);


--
-- Name: estagio_bimestral pk_estagio_bimestral; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio_bimestral
    ADD CONSTRAINT pk_estagio_bimestral PRIMARY KEY (id_estagio_bimestral);


--
-- Name: periodo pk_periodo; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.periodo
    ADD CONSTRAINT pk_periodo PRIMARY KEY (id_periodo);


--
-- Name: setor ramo_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.setor
    ADD CONSTRAINT ramo_pkey PRIMARY KEY (id_setor);


--
-- Name: trabalho trabalho_pkey; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.trabalho
    ADD CONSTRAINT trabalho_pkey PRIMARY KEY (id_trabalho);


--
-- Name: usuario usuario_pk; Type: CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pk PRIMARY KEY (id_usuario);


--
-- Name: alertas alertas_id_usuario_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.alertas
    ADD CONSTRAINT alertas_id_usuario_fk FOREIGN KEY (id_usuario) REFERENCES public.usuario(id_usuario);


--
-- Name: coordenador coordenador_curso_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.coordenador
    ADD CONSTRAINT coordenador_curso_fk FOREIGN KEY (id_curso) REFERENCES public.curso(id_curso);


--
-- Name: estagio_final coordenador_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio_final
    ADD CONSTRAINT coordenador_fk FOREIGN KEY (id_coordenador) REFERENCES public.coordenador(id_cordenador);


--
-- Name: empresa_curso empresa_curso_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa_curso
    ADD CONSTRAINT empresa_curso_fk FOREIGN KEY (id_empresa) REFERENCES public.empresa(id_empresa);


--
-- Name: empresa_curso empresa_curso_fk1; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa_curso
    ADD CONSTRAINT empresa_curso_fk1 FOREIGN KEY (id_curso) REFERENCES public.curso(id_curso);


--
-- Name: empresa_setor empresa_ramo_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa_setor
    ADD CONSTRAINT empresa_ramo_fk FOREIGN KEY (id_empresa) REFERENCES public.empresa(id_empresa);


--
-- Name: empresa_setor empresa_ramo_fk1; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa_setor
    ADD CONSTRAINT empresa_ramo_fk1 FOREIGN KEY (id_setor) REFERENCES public.setor(id_setor);


--
-- Name: estagio_adicao estagio_adicao_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio_adicao
    ADD CONSTRAINT estagio_adicao_fk FOREIGN KEY (id_estagio) REFERENCES public.estagio(id_estagio);


--
-- Name: estagio estagio_empresa_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio
    ADD CONSTRAINT estagio_empresa_fk FOREIGN KEY (id_empresa) REFERENCES public.empresa(id_empresa);


--
-- Name: estagio_final estagio_final_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio_final
    ADD CONSTRAINT estagio_final_fk FOREIGN KEY (id_estagio) REFERENCES public.estagio(id_estagio);


--
-- Name: estagio estagio_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio
    ADD CONSTRAINT estagio_fk FOREIGN KEY (id_supervisor) REFERENCES public.supervisor(id_supervisor);


--
-- Name: estagio estagio_fk2; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio
    ADD CONSTRAINT estagio_fk2 FOREIGN KEY (id_curso) REFERENCES public.curso(id_curso);


--
-- Name: estagio estagio_fk3; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.estagio
    ADD CONSTRAINT estagio_fk3 FOREIGN KEY (id_coordenador) REFERENCES public.coordenador(id_cordenador);


--
-- Name: empresa_convenio fk_empresa; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.empresa_convenio
    ADD CONSTRAINT fk_empresa FOREIGN KEY (id_empresa) REFERENCES public.empresa(id_empresa);


--
-- Name: coordenador fk_id_usuario; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.coordenador
    ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_usuario) REFERENCES public.usuario(id_usuario);


--
-- Name: aluno_estagio id_curso_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.aluno_estagio
    ADD CONSTRAINT id_curso_fk FOREIGN KEY (id_curso) REFERENCES public.curso(id_curso);


--
-- Name: trabalho trabalho_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.trabalho
    ADD CONSTRAINT trabalho_fk FOREIGN KEY (id_empresa) REFERENCES public.empresa(id_empresa);


--
-- Name: usuario usuario_grupo_fk; Type: FK CONSTRAINT; Schema: public; Owner: iris
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_grupo_fk FOREIGN KEY (id_grupo) REFERENCES public.grupo(id_grupo);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

