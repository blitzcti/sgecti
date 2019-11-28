@extends('adminlte::page')

@section('title', 'Ajuda')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/help.css') }}">
@endsection

@section('content_header')
    <h1>Ajuda</h1>
@stop

@section('content')
    @if(session()->has('message'))
        <div class="alert {{ session('saved') ? 'alert-success' : 'alert-error' }} alert-dismissible"
             role="alert">
            {{ session()->get('message') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="box box-default">
        <div class="box-body">
            <?php $i1 = 1; ?>
            @foreach($content as $c => $icontent)

                <section class="accordion">
                    <input type="checkbox" name="collapse" id="handle{{ $i1 }}">
                    <h4 class="handle">
                        <label for="handle{{ $i1 }}"><b>{{ $i1 }}. </b>{{ $c }}</label>
                    </h4>

                    <div class="hcontent">

                        <?php $i2 = 1; ?>
                        @foreach($icontent as $c2 => $icontent2)

                            <section class="accordion">
                                <input type="checkbox" name="collapse" id="handle{{ "{$i1}.{$i2}" }}">
                                <h4 class="handle">
                                    <label for="handle{{ "{$i1}.{$i2}" }}"><b>{{ "{$i1}.{$i2}" }}. </b>
                                        {{ $c2 }}
                                    </label>
                                </h4>

                                <div class="hcontent">
                                    @if($icontent2 == [null])

                                        <p>(EM DESENVOLVIMENTO)</p>

                                    @else
                                        @if($icontent2['desc'] != null)

                                            <h4>Funcionalidade: </h4>
                                            <h5>{{ $icontent2['desc'] }}</h5>

                                        @endif

                                        @if(!ctype_digit(implode('', array_keys($icontent2['content']))))
                                            @foreach($icontent2['content'] as $c3 => $icontent3)
                                                <h3>{{ $c3 }}</h3>

                                                @foreach($icontent3 as $icontent4)

                                                    @if(array_key_exists('img', $icontent4))
                                                        <img src="{{ asset("img/help/{$icontent4['img']}") }}" alt=""/>
                                                    @endif
                                                    <p>{!! $icontent4['text'] !!}</p>
                                                    <br/>

                                                @endforeach
                                            @endforeach
                                        @else
                                            @foreach($icontent2['content'] as $c3 => $icontent3)

                                                @if(array_key_exists('img', $icontent3))
                                                    <img src="{{ asset("img/help/{$icontent3['img']}") }}" alt=""/>
                                                @endif
                                                <p>{!! $icontent3['text'] !!}</p>
                                                <br/>

                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </section>

                            <?php $i2++; ?>
                        @endforeach

                    </div>
                </section>

                <?php $i1++; ?>
            @endforeach

        </div>
    </div>
@endsection
