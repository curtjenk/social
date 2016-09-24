@extends('layouts.master')

@section('title')
    Welcome!
@endsection

@section('content')
    <?php phpinfo(); ?>
    <div class="row text-center">
        <h1>My Social Network</h1>
    </div>

    @include('includes.message-block')

    <div class="row">
        <div class="col-md-6">
            <form action="{{ url('signup') }}" method="post">
                {{-- short hand for adding a hidden input for _token with value Session::token() --}}
                {{csrf_field()}}
                <h3>Sign Up</h3>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your E-mail</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">
                </div>
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="first_name">Your First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name" value="{{ Request::old('first_name') }}">
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Your Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ url('signin') }}"  method="post">
                {{ csrf_field() }}
                <h3>Sign In</h3>
                {{-- using bootstrap has-error class --}}
                <div class="form-group {{ $errors->has('email2') ? 'has-error' : '' }}">
                    <label for="email">Your E-mail</label>
                    <input class="form-control" type="text" name="email2" id="email2" value="{{ Request::old('email2') }}">
                </div>
                <div class="form-group {{ $errors->has('password2') ? 'has-error' : '' }}">
                    <label for="password">Your Password</label>
                    <input class="form-control" type="password" name="password2" id="password2" value="{{ Request::old('password2') }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

    </div>
@endsection
