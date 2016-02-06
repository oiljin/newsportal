@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Результаты поиска</h1>
        </div>
    </div>

    @foreach($articles as $article)
        <div class="media">
            <div class="media-left media-middle">
                <a href="/news-{{$article->alias}}">
                    <img class="media-object" src="{{$article->image->thumbnail('small')}}" alt="">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{$article->name}} <small class="text-muted">{{$article->category->name}}</small></h4>

                {!! $article->intro !!}

                <a href="/news-{{$article->alias}}">Читать новость</a>
            </div>
        </div>
        <hr>
    @endforeach

    {!! $articles->render() !!}

@endsection