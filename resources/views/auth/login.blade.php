@extends('layouts.header-less')

@section('content')
    <form class="form" role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div>
                <input type="password" class="form-control" name="password" placeholder="Password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary">
                <i class="fa fa-btn fa-sign-in"></i>Login
            </button>
        </div>

        <div class="form-group">
            <a class="btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
        </div>
    </form>
@endsection
