@if(count($errors)>0)
<div class="row">
    <div class="col-md-4 col-md-offset-4 error">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
{{-- display messages from the controllers -- put into Session---}}
@if(Session::has('message'))
<div class="row">
    <div class="col-md-4 col-md-offset-4 success">
        <ul>
            @foreach(Session::get('message') as $msg)
            <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif