@extends('layouts.submission')

@section('title', 'All Submissions')

@section('controls')
	<div>@include('applications.partials.pagination')</div>
	<div>{!! $applications->links() !!}</div>
@endsection

@section('body')
	@include('applications.partials.table')
@endsection