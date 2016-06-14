@if($errors->all())
    <ul>
        @foreach($errors->all() as $error)
            <li class="alert alert-danger">{{ $error }}</li>
        @endforeach
    </ul>
@endif