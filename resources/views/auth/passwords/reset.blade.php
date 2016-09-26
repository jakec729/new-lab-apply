@extends('layouts.header-less')

@section('content')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
        {!! csrf_field() !!}

        <input type="hidden" name="token" value="{{ $token }}" placeholder="Email">

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div>
                <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

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
            <button type="submit" class="btn btn-block btn-primary">
                <i class="fa fa-btn fa-refresh"></i>Reset Password
            </button>
        </div>
    </form>
@endsection
