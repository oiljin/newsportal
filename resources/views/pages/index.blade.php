@extends('layout')

@section('content')
    <div class="row">
        @foreach($categories as $category)
            <div class="col-sm-6 col-md-3">
                <a href="/feed/{{$category->alias}}" class="thumbnail">
                    {!! Html::image($category->image->thumbnail('medium')) !!}
                    <div class="caption">
                        <h3>{{$category->name}}</h3>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection