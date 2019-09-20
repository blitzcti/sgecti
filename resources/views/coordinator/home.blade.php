@if($user->isCoordinator())

    <p>Atualmente, você é coordenador de {{ $strCourses }}.</p>

@endif

@if(sizeof($requiringFinish) > 0)

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Estágios finalizados sem relatório final</h3>
        </div>

        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Aluno</th>
                    <th>Empresa</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($requiringFinish as $internship)

                    <tr>
                        <th scope="row">{{ $internship->id }}</th>
                        <td>{{ $internship->ra}}

                            @if((new \App\Models\NSac\Student)->isConnected())
                                {{ (' - ' . $internship->student->nome) ?? '' }}
                            @endif
                        </td>

                        <td>{{ $internship->company->name }} {{ $internship->company->fantasy_name != null ? "(" . $internship->company->fantasy_name . ")" : '' }}</td>
                        <td>
                            <a href="{{ route('coordenador.estagio.detalhes', ['id' => $internship->id]) }}">Detalhes</a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endif

@if(sizeof($proposals) > 0)

    @include('modals.coordinator.proposal.delete')
    @include('modals.coordinator.proposal.approve')

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Propostas de estágio pendentes</h3>
        </div>

        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">Empresa</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Data limite</th>
                    <th scope="col">Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($proposals as $proposal)

                    <tr>
                        <td>{{ $proposal->company->name }}</td>
                        <td>{{ $proposal->description }}</td>
                        <td>{{ $proposal->deadline->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('coordenador.proposta.detalhes', ['id' => $proposal->id]) }}">Detalhes</a>
                            |
                            <a href="#" onclick="approveProposalId('{{ $proposal->id }}'); return false;"
                               data-toggle="modal" class="text-green" data-target="#proposalApproveModal">Aprovar</a>
                            |
                            <a href="#" onclick="deleteProposalId('{{ $proposal->id }}'); return false;"
                               data-toggle="modal" class="text-red" data-target="#proposalDeleteModal">Excluir</a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endif
