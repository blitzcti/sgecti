/*-------------------CONFIGURAÇÕES-------------------------*/

DROP TABLE IF EXISTS config_geral;
CREATE TABLE config_geral
(
    id_config_geral SERIAL NOT NULL PRIMARY KEY,
    anos_max        INT    NOT NULL,
    data_ini        DATE   NOT NULL,
    data_fim        DATE DEFAULT NULL
);

DROP TABLE IF EXISTS curso;
CREATE TABLE curso
(
    id_curso   INT         NOT NULL PRIMARY KEY, --entrada manual
    nome_curso VARCHAR(30) NOT NULL,
    --cor VARCHAR(6) NOT NULL,
    ativo      BOOLEAN     NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS config_curso;
CREATE TABLE config_curso
(
    id_config_curso SERIAL NOT NULL PRIMARY KEY,
    id_curso        INT    NOT NULL REFERENCES curso,
    ano_min         INT    NOT NULL,
    semestre_min    INT    NOT NULL
);

DROP TABLE IF EXISTS coordenador;
CREATE TABLE coordenador
(
    id_coordenador SERIAL      NOT NULL PRIMARY KEY,
    nome           VARCHAR(30) NOT NULL,
    id_curso       INT         NOT NULL REFERENCES curso,
    vigencia_ini   DATE        NOT NULL,
    vigencia_fim   DATE DEFAULT NULL
);

/*-------------------EMPRESAS-------------------------*/

DROP TABLE IF EXISTS endereco;
CREATE TABLE endereco
(
    id_endereco BIGSERIAL    NOT NULL PRIMARY KEY,

    cep         VARCHAR(8)   NOT NULL,
    rua         VARCHAR(100) NOT NULL,
    numero      VARCHAR(6)   NOT NULL,
    bairro      VARCHAR(100) NOT NULL,
    complemento VARCHAR(30) DEFAULT NULL,
    cidade      VARCHAR(40)  NOT NULL,
    uf          VARCHAR(2)   NOT NULL,
    telefone    BIGINT       NOT NULL
);

DROP TABLE IF EXISTS empresa;
CREATE TABLE empresa
(
    --Identificadores
    id_empresa    BIGSERIAL    NOT NULL PRIMARY KEY,
    cpf_cnpj      VARCHAR(15)  NOT NULL UNIQUE,
    pj            BOOLEAN      NOT NULL DEFAULT TRUE,

    --Nomes
    nome          VARCHAR(100) NOT NULL,
    nome_fantasia VARCHAR(100)          DEFAULT NULL,

    --Endereço
    id_endereco   BIGINT       NOT NULL REFERENCES endereco,

    --Empresa/PF ainda operante
    ativa         BOOLEAN      NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS ctps;
CREATE TABLE ctps
(
    id_ctps BIGSERIAL   NOT NULL PRIMARY KEY,
    ctps    VARCHAR(11) NOT NULL,
    ra      BIGINT      NOT NULL
);

/*-------------------ESTAGIO-------------------------*/

DROP TABLE IF EXISTS estagio;
CREATE TABLE estagio
(
    --Identificação
    id_estagio BIGSERIAL NOT NULL PRIMARY KEY,
    --ra BIGINT NOT NULL,
    id_empresa BIGINT    NOT NULL REFERENCES empresa,
    --Datas
    data_ini   DATE      NOT NULL,
    data_fim   DATE      NOT NULL
    --Dias da Semana
    --????
);

/*-------------------PAPELADA-------------------------*/

DROP TABLE IF EXISTS aditivo;
CREATE TABLE aditivo
(
    --Controle
    id_aditivo      BIGINT NOT NULL PRIMARY KEY,
    --ra
    data_ini        DATE   NOT NULL,
    data_fim        DATE   NOT NULL, --!!!!!!!

    --Novos Horários
    segunda_entrada TIME DEFAULT NULL,
    segunda_saida   TIME DEFAULT NULL,
    terca_entrada   TIME DEFAULT NULL,
    terca_saida     TIME DEFAULT NULL,
    quarta_entrada  TIME DEFAULT NULL,
    quarta_saida    TIME DEFAULT NULL,
    quinta_entrada  TIME DEFAULT NULL,
    quinta_saida    TIME DEFAULT NULL,
    sexta_entrada   TIME DEFAULT NULL,
    sexta_saida     TIME DEFAULT NULL,
    sabado_entrada  TIME DEFAULT NULL,
    sabado_saida    TIME DEFAULT NULL
);

DROP TABLE IF EXISTS relatorio;
CREATE TABLE relatorio
(
    id_relatorio BIGSERIAL NOT NULL PRIMARY KEY,
    --ra
    tipo         INT       NOT NULL DEFAULT 1,
    dia          DATE      NOT NULL
);

/*-------------------DADOS DO ALUNO-------------------------*/

--????

/*-----------------PROPOSTAS DE ESTÁGIO --------------------*/

DROP TABLE IF EXISTS proposta;
CREATE TABLE proposta
(
    --Identificacao
    id_proposta     BIGSERIAL     NOT NULL PRIMARY KEY,
    id_empresa      BIGINT        NOT NULL REFERENCES empresa,
    data_limite     DATE          NOT NULL,
    id_curso        VARCHAR(20)   NOT NULL,

    --Informações
    remuneracao     FLOAT         NOT NULL,
    descricao       VARCHAR(2000) NOT NULL,
    observacoes     VARCHAR(500) DEFAULT NULL,

    --Horários
    segunda_entrada TIME         DEFAULT NULL,
    segunda_saida   TIME         DEFAULT NULL,
    terca_entrada   TIME         DEFAULT NULL,
    terca_saida     TIME         DEFAULT NULL,
    quarta_entrada  TIME         DEFAULT NULL,
    quarta_saida    TIME         DEFAULT NULL,
    quinta_entrada  TIME         DEFAULT NULL,
    quinta_saida    TIME         DEFAULT NULL,
    sexta_entrada   TIME         DEFAULT NULL,
    sexta_saida     TIME         DEFAULT NULL,
    sabado_entrada  TIME         DEFAULT NULL,
    sabado_saida    TIME         DEFAULT NULL
);
