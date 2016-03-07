@extends('layouts.app')
@inject('applications', 'App\ApplicationRepository')

@section('content')
    <div class="container-fluid submissions">
        <div class="row">
            <div class="col-md-2 filter-sidebar">
                <ul class="list-unstyled submission-filters">
                    <li><a class="{{set_active('applications')}}" href="{{url('/applications')}}">All Submissions <small>({{$applications->count()}})</small></a></li>
                    <li><a class="{{set_active('applications/shortlisted')}}" href="{{url('/applications/shortlisted')}}">Shortlisted <small>({{$applications->countShortlisted()}})</small></a></li>
                    @if (Auth::user()->hasRole('admin'))
                        <li><a class="{{set_active('users')}}" href="{{ url('/users') }}">Users</a></li>
                    @endif

                </ul>
            </div>
            <div class="col-md-10 submissions-body">
                <div class="container-fluid">
                    <header class="submission__header">
                        <h1 class="submission__heading">@yield('title')</h1>
                        <div class="submission-controls">@yield('controls')</div>
                    </header>
                    @yield('body')
                </div>
            </div>
        </div>
    </div>
@endsection


