@extends('layouts.master')

@section('content')
    <div class="row">
        <div id="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Search</li>
                <li class="active">View</li>
            </ol>
        </div>
        @if(empty($photoInfo))
            <div><h3>No result found</h3></div>
        @else
            <table class="table table-striped table-bordered photo-info">
                <tr><th>Title</th><td>{{ $photoInfo->title->_content }}</td></tr>
                <tr><th>Description</th><td>{{ $photoInfo->description->_content }}</td></tr>
                <tr><th>Owner</th><td>{{ $photoInfo->owner->username }}</td></tr>
                <tr><th>Name</th><td>{{ $photoInfo->owner->realname }}</td></tr>
                <tr><th>Posted</th><td>{{ date("j/n/Y", $photoInfo->dates->posted) }}</td></tr>
                <tr><th>Photo Url</th><td><a href="{{ $photoInfo->urls->url[0]->_content }}">{{ $photoInfo->urls->url[0]->_content }}</a></td></tr>
            </table>
            @if(!empty($photo))
                <img class="img-responsive" src="{{ $photo->source }}" alt="{{ $photoInfo->title->_content }}" />
            @endif
        @endif
    </div>
@endsection