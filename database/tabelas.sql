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
    id_curso   SERIAL      NOT NULL PRIMARY KEY,
    nome_curso VARCHAR(30) NOT NULL,
    cor        VARCHAR(6)  NOT NULL,
    ativo      BOOLEAN     NOT NULL DEFAULT TRUE
);

INSERT INTO curso
VALUES (DEFAULT, 'Mecânica', '000000', DEFAULT);

INSERT INTO curso
VALUES (DEFAULT, 'Eletrotécnica', 'AAAAAA', FALSE);

INSERT INTO curso
VALUES (DEFAULT, 'Edificações', 'BBBBBB', FALSE);

INSERT INTO curso
VALUES (DEFAULT, 'Processamento de dados', 'CCCCCC', FALSE);

INSERT INTO curso
VALUES (DEFAULT, 'Eletrônica', 'DDDDDD', DEFAULT);

INSERT INTO curso
VALUES (DEFAULT, 'Decoração', 'EEEEEE', FALSE);

INSERT INTO curso
VALUES (DEFAULT, 'Informática', 'FFFFFF', DEFAULT);

DROP TABLE IF EXISTS config_curso;
CREATE TABLE config_curso
(
    id_config_curso SERIAL NOT NULL PRIMARY KEY,
    id_curso        INT    NOT NULL REFERENCES curso,

    ano_min         INT    NOT NULL,
    semestre_min    INT    NOT NULL,

    horas_min       INT    NOT NULL,
    meses_min       INT    NOT NULL,
    meses_ctps_min  INT    NOT NULL,

    nota_min        INT    NOT NULL
);

DROP TABLE IF EXISTS coordenador;
CREATE TABLE coordenador
(
    id_coordenador SERIAL      NOT NULL PRIMARY KEY,
    id_curso       INT         NOT NULL REFERENCES curso,

    nome           VARCHAR(30) NOT NULL,

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
    uf          VARCHAR(2)   NOT NULL
);

DROP TABLE IF EXISTS empresa;
CREATE TABLE empresa
(
    -- Identificadores
    id_empresa    BIGSERIAL    NOT NULL PRIMARY KEY,
    cpf_cnpj      VARCHAR(15)  NOT NULL UNIQUE,
    pj            BOOLEAN      NOT NULL DEFAULT TRUE,

    -- Nomes
    nome          VARCHAR(100) NOT NULL,
    nome_fantasia VARCHAR(100)          DEFAULT NULL,
    email         VARCHAR(100) NOT NULL,
    telefone      VARCHAR(11)  NOT NULL,

    -- Representante legal da empresa
    representante VARCHAR(50)  NOT NULL,
    cargo         VARCHAR(50)  NOT NULL,

    -- Endereço
    id_endereco   BIGINT       NOT NULL REFERENCES endereco,

    -- Empresa/PF ainda operante
    ativa         BOOLEAN      NOT NULL DEFAULT TRUE
);

-- Setores dentro da empresa
DROP TABLE IF EXISTS setor;
CREATE TABLE setor
(
    id_setor  BIGSERIAL   NOT NULL PRIMARY KEY,

    nome      VARCHAR(50) NOT NULL,
    descricao TEXT,

    ativo     BOOLEAN     NOT NULL DEFAULT TRUE
);

-- Supervisores de estágio da empresa
DROP TABLE IF EXISTS supervisor;
CREATE TABLE supervisor
(
    id_supervisor SERIAL      NOT NULL PRIMARY KEY,
    id_empresa    BIGINT      NOT NULL REFERENCES empresa,

    nome          VARCHAR(50) NOT NULL,
    email         VARCHAR(50) NOT NULL,

    telefone      VARCHAR(11) NOT NULL,
    ramal         CHAR(5)              DEFAULT NULL,

    ativo         BOOLEAN     NOT NULL DEFAULT TRUE
);

-- Empresas que possuem convênio com o colégio
DROP TABLE IF EXISTS convenio;
CREATE TABLE convenio
(
    id_convenio BIGSERIAL NOT NULL PRIMARY KEY,
    id_empresa  BIGINT    NOT NULL REFERENCES empresa,

    validade    DATE      NOT NULL,
    obs         TEXT,

    ativo       BOOLEAN DEFAULT true
);

-- Cursos que a empresa oferece estágios
DROP TABLE empresa_curso;
CREATE TABLE empresa_curso
(
    id_empresa_curso SERIAL NOT NULL PRIMARY KEY,
    id_empresa       BIGINT NOT NULL REFERENCES empresa,
    id_curso         BIGINT NOT NULL REFERENCES curso
);

DROP TABLE IF EXISTS ctps;
CREATE TABLE ctps
(
    id_ctps BIGSERIAL   NOT NULL PRIMARY KEY,
    ctps    VARCHAR(11) NOT NULL
);

/*-------------------ESTAGIO-------------------------*/

DROP TABLE IF EXISTS horario;
CREATE TABLE horario
(
    id_horario      BIGSERIAL NOT NULL PRIMARY KEY,

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

-- Tabela com as situações do estágio (em aberto, finalizado, cancelado ou inválido)
DROP TABLE IF EXISTS situacao;
CREATE TABLE situacao
(
    id_situacao BIGSERIAL   NOT NULL PRIMARY KEY,
    descricao   VARCHAR(50) NOT NULL
);

INSERT INTO situacao
VALUES (DEFAULT, 'Em aberto');

INSERT INTO situacao
VALUES (DEFAULT, 'Finalizado');

INSERT INTO situacao
VALUES (DEFAULT, 'Cancelado');

INSERT INTO situacao
VALUES (DEFAULT, 'Inválido');

DROP TABLE IF EXISTS estagio;
CREATE TABLE estagio
(
    -- Identificação
    id_estagio          BIGSERIAL   NOT NULL PRIMARY KEY,
    ra                  VARCHAR(7)  NOT NULL,
    id_ctps             BIGINT                                   DEFAULT NULL REFERENCES ctps,

    id_empresa          BIGINT      NOT NULL REFERENCES empresa,
    id_supervisor       BIGINT      NOT NULL REFERENCES supervisor,
    id_setor            BIGINT      NOT NULL REFERENCES setor,
    id_coordenador      BIGINT      NOT NULL REFERENCES coordenador,

    -- Datas
    data_ini            DATE        NOT NULL,
    data_fim            DATE        NOT NULL,

    -- Horários da semana
    id_horario          BIGINT      NOT NULL REFERENCES horario,

    -- Informações adicionais do estágio
    atividades          TEXT        NOT NULL,

    protocolo           VARCHAR(15) NOT NULL,

    id_situacao         INT         NOT NULL REFERENCES situacao DEFAULT 1,
    motivo_cancelamento TEXT                                     DEFAULT NULL,

    observacao          TEXT                                     DEFAULT NULL,
    ativo               BOOLEAN     NOT NULL                     DEFAULT TRUE
);

/*-------------------PAPELADA-------------------------*/

DROP TABLE IF EXISTS aditivo;
CREATE TABLE aditivo
(
    -- Controle
    id_aditivo BIGINT     NOT NULL PRIMARY KEY,
    ra         VARCHAR(7) NOT NULL,
    data_ini   DATE       NOT NULL,
    data_fim   DATE       NOT NULL,

    -- Novos horários
    id_horario BIGINT     NOT NULL REFERENCES horario,

    -- Informações adicionais do termo aditivo
    protocolo  VARCHAR(9) NOT NULL,
    obs        TEXT DEFAULT NULL
);

DROP TABLE IF EXISTS relatorio_bimestral;
CREATE TABLE relatorio_bimestral
(
    id_relatorio_bimestral BIGSERIAL   NOT NULL PRIMARY KEY,
    id_estagio             BIGINT      NOT NULL REFERENCES estagio,

    dia                    DATE        NOT NULL,
    protocolo              VARCHAR(10) NOT NULL
);

DROP TABLE IF EXISTS relatorio_final;
CREATE TABLE relatorio_final
(
    id_relatorio_final BIGSERIAL     NOT NULL PRIMARY KEY,
    id_estagio         BIGINT        NOT NULL REFERENCES estagio,

    dia                DATE          NOT NULL,

    nota_i_a           INT           NOT NULL,
    nota_i_b           INT           NOT NULL,
    nota_i_c           INT           NOT NULL,
    nota_ii_a          INT           NOT NULL,
    nota_ii_b          INT           NOT NULL,
    nota_ii_c          INT           NOT NULL,
    nota_ii_d          INT           NOT NULL,
    nota_iii_a         INT           NOT NULL,
    nota_iii_b         INT           NOT NULL,
    nota_iv_a          INT           NOT NULL,
    nota_iv_b          INT           NOT NULL,
    nota_iv_c          INT           NOT NULL,
    nota_final         NUMERIC(5, 2) NOT NULL,

    id_coordenador     BIGINT        NOT NULL REFERENCES coordenador,
    horas_cumpridas    INT           NOT NULL,
    data_termino       DATE          NOT NULL,
    numero_aprovacao   VARCHAR(10),
    observacoes        TEXT,
);

/*-----------------PROPOSTAS DE ESTÁGIO --------------------*/

DROP TABLE IF EXISTS proposta;
CREATE TABLE proposta
(
    --Identificacao
    id_proposta     BIGSERIAL   NOT NULL PRIMARY KEY,
    id_empresa      BIGINT      NOT NULL REFERENCES empresa,
    data_limite     DATE        NOT NULL,
    id_curso        VARCHAR(20) NOT NULL,

    --Informações
    remuneracao     FLOAT       NOT NULL,
    descricao       TEXT        NOT NULL,
    observacoes     TEXT DEFAULT NULL,

    --Horários
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
