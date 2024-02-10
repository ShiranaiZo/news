@extends('public/template/layout')

@section('title', $article->title)

@section('content')
<div class="card">
    <div class="card-body m-4">
        <h1 class="text-center">{{ $article->title }}</h1>
        <h6 class="text-center">{{ @$article->user->name }} | {{ date('d M Y, H:i', strtotime($article->publication_date)) }}</h6>
        <div class="text-center">
            <img src="{{ asset($article->image) }}" class="img mx-auto my-3" style="width: 500px;">
        </div>
        <p>{!! $article->content !!}</p>
    </div>
</div>
@endsection
