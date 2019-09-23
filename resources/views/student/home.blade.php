@section('css')
    <style type="text/css">
        .small-box p {
            margin-bottom: 5px;
        }

        .small-box.bg-white:hover {
            color: #2a2a2a;
        }

        .small-box.bg-white > .small-box-footer {
            color: #2a2a2a;
        }
    </style>
@endsection

@if(sizeof($proposals) > 0)

    @foreach($proposals as $proposal)

        <div class="col-sm-4">
            <div class="small-box bg-{{ (sizeof($proposal->courses) == 1) ? $proposal->courses->first()->color->name : 'white' }}">
                <div class="inner">
                    <h3>{{ ($proposal->type == \App\Models\Proposal::INTERNSHIP) ? 'Estágio' : 'IC' }}</h3>

                    <p>{{ $proposal->company->name }}</p>
                    <p>{{ join(', ', $proposal->courses->map(function ($c) { return $c->name; })->toArray()) }}</p>
                    <p>Até {{ $proposal->deadline->format('d/m/Y') }}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-{{ ($proposal->type == \App\Models\Proposal::INTERNSHIP) ? 'id-badge' : 'flask' }}"></i>
                </div>
                <a href="{{ route('aluno.proposta.detalhes', ['id' => $proposal->id]) }}" class="small-box-footer">Mais detalhes <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    @endforeach

@endif
