<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted' => 'O campo :attribute deve ser aceito.',
    'active' => 'O campo :attribute não está definido como ativo.',
    'active_url' => 'O campo :attribute não é uma URL válida.',
    'after' => 'O campo :attribute deve ser uma data posterior a :date.',
    'after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a :date.',
    'age' => 'A idade mínima do aluno do campo :attribute é 16 anos.',
    'alpha' => 'O campo :attribute só pode conter letras.',
    'alpha_dash' => 'O campo :attribute só pode conter letras, números e traços.',
    'alpha_num' => 'O campo :attribute só pode conter letras e números.',
    'already_has_agreement' => 'O campo :attribute contém uma empresa já conveniada.',
    'already_has_internship' => 'O campo :attribute contém um RA de um aluno que já está fazendo estágio.',
    'already_has_job' => 'O campo :attribute contém um RA de um aluno que já está trabalhando.',
    'array' => 'O campo :attribute deve ser uma matriz.',
    'before' => 'O campo :attribute deve ser uma data anterior :date.',
    'before_or_equal' => 'O campo :attribute deve ser uma data anterior ou igual a :date.',
    'between' => [
        'numeric' => 'O campo :attribute deve ser entre :min e :max.',
        'file' => 'O campo :attribute deve ser entre :min e :max kilobytes.',
        'string' => 'O campo :attribute deve ser entre :min e :max caracteres.',
        'array' => 'O campo :attribute deve ter entre :min e :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'cnpj' => 'O campo :attribute deve ser um CNPJ válido.',
    'cpf' => 'O campo :attribute deve ser um CPF válido.',
    'company_has_course' => 'O curso do campo :attribute não é de um curso que a empresa aborda.',
    'company_has_email' => 'A empresa do campo :attribute não possui um email.',
    'company_has_student_course' => 'O aluno do campo :attribute não é de um curso que a empresa aborda.',
    'company_has_sector' => 'O setor do campo :attribute não é de um setor que a empresa aborda.',
    'company_has_supervisor' => 'O supervisor do campo :attribute não é de um supervisor que a empresa possui.',
    'confirmed' => 'O campo :attribute de confirmação não confere.',
    'current_password' => 'O campo :attribute deve ser a senha atual do usuário.',
    'date' => 'O campo :attribute não é uma data válida.',
    'date_format' => 'O campo :attribute não corresponde ao formato :format.',
    'different' => 'Os campos :attribute e :other devem ser diferentes.',
    'digits' => 'O campo :attribute deve ter :digits dígitos.',
    'digits_between' => 'O campo :attribute deve ter entre :min e :max dígitos.',
    'dimensions' => 'O campo :attribute tem dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute campo tem um valor duplicado.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'exists' => 'O campo :attribute selecionado é inválido.',
    'file' => 'O campo :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve ter um valor.',
    'gt' => [
        'numeric' => 'O campo :attribute deve ser maior que :value.',
        'file' => 'O campo :attribute deve ser maior que :value kilobytes.',
        'string' => 'O campo :attribute deve ser maior que :value caracteres.',
        'array' => 'O campo :attribute deve conter mais de :value itens.',
    ],
    'gte' => [
        'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
        'file' => 'O campo :attribute deve ser maior ou igual a :value kilobytes.',
        'string' => 'O campo :attribute deve ser maior ou igual a :value caracteres.',
        'array' => 'O campo :attribute deve conter :value itens ou mais.',
    ],
    'image' => 'O campo :attribute deve ser uma imagem.',
    'in' => 'O campo :attribute selecionado é inválido.',
    'internship_not_active' => 'O campo :attribute não está no estado Em aberto.',
    'in_array' => 'O campo :attribute não existe em :other.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'ip' => 'O campo :attribute deve ser um endereço de IP válido.',
    'ipv4' => 'O campo :attribute deve ser um endereço IPv4 válido.',
    'ipv6' => 'O campo :attribute deve ser um endereço IPv6 válido.',
    'json' => 'O campo :attribute deve ser uma string JSON válida.',
    'lt' => [
        'numeric' => 'O campo :attribute deve ser menor que :value.',
        'file' => 'O campo :attribute deve ser menor que :value kilobytes.',
        'string' => 'O campo :attribute deve ser menor que :value caracteres.',
        'array' => 'O campo :attribute deve conter menos de :value itens.',
    ],
    'lte' => [
        'numeric' => 'O campo :attribute deve ser menor ou igual a :value.',
        'file' => 'O campo :attribute deve ser menor ou igual a :value kilobytes.',
        'string' => 'O campo :attribute deve ser menor ou igual a :value caracteres.',
        'array' => 'O campo :attribute não deve conter mais que :value itens.',
    ],
    'max' => [
        'numeric' => 'O campo :attribute não pode ser superior a :max.',
        'file' => 'O campo :attribute não pode ser superior a :max kilobytes.',
        'string' => 'O campo :attribute não pode ser superior a :max caracteres.',
        'array' => 'O campo :attribute não pode ter mais do que :max itens.',
    ],
    'max_years' => 'O campo :attribute é de um aluno que já passou do limite de anos para estágio.',
    'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min_interval' => 'O campo :attribute deve ter um intervalo de pelo menos :months meses.',
    'min_semester' => 'O campo :attribute é de um aluno que não está no semestre mínimo.',
    'min_year' => 'O campo :attribute é de um aluno que não está no ano mínimo.',
    'min' => [
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'file' => 'O campo :attribute deve ter pelo menos :min kilobytes.',
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
        'array' => 'O campo :attribute deve ter pelo menos :min itens.',
    ],
    'max_hours' => 'O campo :attribute deve ter um intervalo de até 6h.',
    'no_agreement' => 'O campo :attribute é de uma empresa que não possui um convênio ativo.',
    'not_active' => 'O campo :attribute selecionado não está ativo.',
    'not_in' => 'O campo :attribute selecionado é inválido.',
    'not_regex' => 'O campo :attribute possui um formato inválido.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'present' => 'O campo :attribute deve estar presente.',
    'ra' => 'O campo :attribute deve ser um RA válido.',
    'regex' => 'O campo :attribute tem um formato inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é obrigatório quando :other for :value.',
    'required_unless' => 'O campo :attribute é obrigatório exceto quando :other for :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values estão presentes.',
    'same' => 'Os campos :attribute e :other devem corresponder.',
    'same_course' => 'O campo :attribute contém um RA de um aluno de outro curso.',
    'size' => [
        'numeric' => 'O campo :attribute deve ser :size.',
        'file' => 'O campo :attribute deve ser :size kilobytes.',
        'string' => 'O campo :attribute deve ser :size caracteres.',
        'array' => 'O campo :attribute deve conter :size itens.',
    ],
    'string' => 'O campo :attribute deve ser uma string.',
    'temp_of' => 'O campo :attribute deve conter um usuário diferente.',
    'timezone' => 'O campo :attribute deve ser uma zona válida.',
    'unique' => 'O campo :attribute já está sendo utilizado.',
    'uploaded' => 'Ocorreu uma falha no upload do campo :attribute.',
    'url' => 'O campo :attribute tem um formato inválido.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
    'attributes' => [
        'name' => 'Nome',
        'color' => 'Cor',
        'active' => 'Ativo',
        'startDate' => 'Data de início',
        'endDate' => 'Data de término',
        'date' => 'Date',

        'current_password' => 'Senha atual',
        'password' => 'Senha',
        'group' => 'Grupo',

        'tempOf' => 'Temporário de',

        'maxYears' => 'Anos máximos',
        'minYear' => 'Ano mínimo',
        'minSemester' => 'Semestre mínimo',
        'minHour' => 'Horas mínimas',
        'minMonth' => 'Meses mínimos',
        'minMonthCTPS' => 'Meses mínimos (CTPS)',
        'minGrade' => 'Nota mínima',
        'hasConfig' => 'Adicionar configuração?',

        'supervisorName' => 'Nome do supervisor',
        'supervisorEmail' => 'Email do supervisor',
        'supervisorPhone' => 'Telefone do supervisor',

        'company' => 'Empresa',

        'cep' => 'CEP',
        'uf' => 'UF',
        'city' => 'Cidade',
        'street' => 'Rua',
        'number' => 'Número',
        'district' => 'Bairro',
        'phone' => 'Telefone',
        'email' => 'Email',
        'extension' => 'Ramal',
        'agreementExpiration' => 'Validade do convênio',

        'cpfCnpj' => 'CPF / CNPJ',
        'ie' => 'I.E.',
        'companyName' => 'Razão social',
        'representativeName' => 'Nome do representante',
        'representativeRole' => 'Cargo do representante',
        'sector' => 'Setor',
        'sectors' => 'Setores',
        'course' => 'Curso',
        'courses' => 'Cursos',
        'hasAgreement' => 'Registrar convênio?',

        'description' => 'Descrição',

        'ra' => 'RA',
        'activities' => 'Atividades',
        'observation' => 'Observações',
        'supervisor' => 'Supervisor',
        'protocol' => 'Protocolo',
        'ctps' => 'CTPS',
        'hasSchedule' => 'Editar horário?',
        'has2Schedules' => '2 turnos?',

        'grades' => 'Anos',
        'periods' => 'Períodos',
        'internships' => 'Estágios',
        'students' => 'Alunos',

        'subject' => 'Assunto',

        'monS' => 'Segunda (entrada)',
        'monE' => 'Segunda (saída)',
        'monS2' => 'Segunda (entrada - 2º horário)',
        'monE2' => 'Segunda (saída - 2º horário)',
        'tueS' => 'Terça (entrada)',
        'tueE' => 'Terça (saída)',
        'tueS2' => 'Terça (entrada - 2º horário)',
        'tueE2' => 'Terça (saída - 2º horário)',
        'wedS' => 'Quarta (entrada)',
        'wedE' => 'Quarta (saída)',
        'wedS2' => 'Quarta (entrada - 2º horário)',
        'wedE2' => 'Quarta (saída - 2º horário)',
        'thuS' => 'Quinta (entrada)',
        'thuE' => 'Quinta (saída)',
        'thuS2' => 'Quinta (entrada - 2º horário)',
        'thuE2' => 'Quinta (saída - 2º horário)',
        'friS' => 'Sexta (entrada)',
        'friE' => 'Sexta (saída)',
        'friS2' => 'Sexta (entrada - 2º horário)',
        'friE2' => 'Sexta (saída - 2º horário)',
        'satS' => 'Sábado (entrada)',
        'satE' => 'Sábado (saída)',
        'satS2' => 'Sábado (entrada - 2º horário)',
        'satE2' => 'Sábado (saída - 2º horário)',

        'reportDate' => 'Data do relatório',
    ],
];
