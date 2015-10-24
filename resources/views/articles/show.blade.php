@extends('layout.partials.show')

@section('name')
    {{ $article->name }}
@stop

@section('show')
    {{ $article->description }}
@stop