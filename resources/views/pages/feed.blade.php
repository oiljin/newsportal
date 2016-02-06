@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($category)
                <h1>{{$category->name}}</h1>
            @else
                <h1>Все новости</h1>
            @endif
        </div>
    </div>

    <div class="row">
        <form action="">
            <div class="col-md-2 col-md-offset-8  text-right">
                по алфавиту:
                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                    <button type="submit" value="name_asc" name="order_by" class="btn btn-default<?= $order_by =='name_asc' ? ' active' : '' ?>"><i class="glyphicon glyphicon-sort-by-alphabet"></i></button>
                    <button type="submit" value="name_desc" name="order_by" class="btn btn-default<?= $order_by =='name_desc' ? ' active' : '' ?>"><i class="glyphicon glyphicon-sort-by-alphabet-alt"></i></button>
                </div>
            </div>
            <div class="col-md-2 text-right">
                по дате:
                <div class="btn-group btn-group-xs" role="group" aria-label="...">
                    <button type="submit" value="date_asc" name="order_by" class="btn btn-default<?= $order_by =='date_asc' ? ' active' : '' ?>"><i class="glyphicon glyphicon-sort-by-order"></i></button>
                    <button type="submit" value="date_desc" name="order_by" class="btn btn-default<?= $order_by =='date_desc' ? ' active' : '' ?>"><i class="glyphicon glyphicon-sort-by-order-alt"></i></button>
                </div>
            </div>
            <input type="hidden" name="page" value="{{$page}}">
        </form>
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