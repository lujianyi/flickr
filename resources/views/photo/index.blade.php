@extends('layouts.master')

@section('content')
    <div class="row">
        @include('photo._form')
        <div class="text-center">
            <img class="img-responsive" src="/img/flickr_logo.png" alt="Flickr">
        </div>
    </div>
@endsection