@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">{{$article->name}}</h1>
            <h4 class="text-center">{{$article->category->name}}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            {!! Html::image($article->image->thumbnail('original')) !!}
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            {!! $article->text !!}
        </div>
    </div>


@endsection