@extends('layouts.app')
@inject('applications', 'App\ApplicationRepository')

@section('content')
    <div class="container-fluid submissions">
        <div class="row">
            <div class="col-md-2 filter-sidebar">
                <ul class="list-unstyled submission-filters">
                    <li><a href="#" class="active">All Submissions <small>({{$applications->count()}})</small></a></li>
                    <li><a href="#">Shortlisted <small>({{$applications->countShortlisted()}})</small></a></li>
                    @if (Auth::user()->hasRole('admin'))
                        <li><a href="{{ url('/users') }}">Users</a></li>
                        <li><a href="{{ url('/applications') }}">Applications</a></li>
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


