@extends('layouts.master')

@section('content')
    <div class="row">
        <div id="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">List</li>
            </ol>
        </div>
        @if(empty($photoList) or empty($photoList->photo) or count($photoList->photo) <= 0)
            <div><h3>No result found</h3></div>
        @else
            <h3>Results</h3>
            <p class="text-success">{{ $photoList->total }} {{ $photoList->total > 1 ? 'photos' : 'photo' }} found.</p>
            @include('layouts._pagination', ['page' => $photoList->page, 'pageCount' => $photoList->pages, 'url' => $url])
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="text-left col-lg-2">Id</th>
                    <th class="text-left col-lg-9">Title</th>
                    <th class="text-center col-lg-1"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($photoList->photo as $photo)
                    <tr>
                        <td class="text-left">{{ $photo->id }}</td>
                        <td class="text-left">{{ $photo->title }}</td>
                        <td class="text-center"><a href="{{ route('show', ['id' => $photo->id]) }}" class="btn btn-sm btn-default" aria-hidden="true"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('layouts._pagination', ['page' => $photoList->page, 'pageCount' => $photoList->pages, 'url' => $url])
        @endif
    </div>
@endsection