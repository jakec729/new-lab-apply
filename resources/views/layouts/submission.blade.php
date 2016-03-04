@extends('layouts.app')

@section('content')
    <div class="container-fluid submissions">
        <div class="row">
            <div class="col-md-2 filter-sidebar">
                <ul class="list-unstyled submission-filters">
                    <li><a href="#" class="active">All Submissions <small>(245)</small></a></li>
                    <li><a href="#">Shortlisted <small>(67)</small></a></li>
                </ul>
            </div>
            <div class="col-md-10 submissions-body">
                <div class="container-fluid">
                    <header class="submission__header clearfix">
                        <h1 class="submission__heading pull-left">@yield('title')</h1>
                        <div class="submission-controls clearfix pull-right">
                            @yield('controls')
                        </div>
                    </header>
                    @yield('body')
                </div>
            </div>
        </div>
    </div>
@endsection


