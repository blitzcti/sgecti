<html lang="pt-br">
<head>
    <title>Vaga de estágio</title>
</head>

<body>
<p> Olá, {{ $student->nome }}! </p>
<p>Vaga de estágio</p>

<p>Empresa: {{ $proposal->company->name }} </p>
<p>Descrição: {{ $proposal->description }} </p>
<p>Remuneração: {{ $proposal->remuneration }} </p>
<p>Observações: {{ $proposal->observation }} </p>

</body>
</html>
