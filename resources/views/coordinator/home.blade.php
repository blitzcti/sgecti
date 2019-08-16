<p>Atualmente, você é coordenador de {{ $strCourses }}.</p>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Estágios finalizados sem relatório final</h3>
    </div>

    <div class="box-body">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
            </tr>
            </thead>

            <tbody>
            @foreach($requiringFinish as $internship)

                <tr>
                    <th scope="row">{{ $internship->id }}</th>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Propostas de estágio</h3>
    </div>

    <div class="box-body">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
            </tr>
            </thead>

            <tbody>
            @foreach($proposals as $proposal)

                <tr>
                    <th scope="row">{{ $proposal->id }}</th>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
</div>
