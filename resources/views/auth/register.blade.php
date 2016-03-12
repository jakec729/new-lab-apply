@extends('layouts.header-less')

@section('content')
    <form class="form" role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <div>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

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

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <div>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div>
                <label for="make_admin">
                    <input type="checkbox" name="make_admin"> &nbsp; Make Admin
                </label>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary">
                <i class="fa fa-btn fa-user"></i>Register
            </button>
        </div>
    </form>
@endsection
