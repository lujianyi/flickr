<form class="form-inline" action="{{ route('search') }}" method="GET">
    <div class="form-group">
        <label for="text">Input text to search the photos</label>
        <input type="text" class="form-control" id="text" name="text" placeholder="search">
    </div>
    <button type="submit" class="btn btn-default">Search</button>
</form>
@if (count($errors) > 0)
    <div class="alert alert-danger" style="margin-top:20px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif