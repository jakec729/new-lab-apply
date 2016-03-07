@extends('layouts.submission')

@section('title', 'Shortlisted')

@section('controls')
	<div>@include('applications.partials.pagination')</div>
	<div>{!! $applications->links() !!}</div>
@endsection

@section('body')
	@include('applications.partials.table')
@endsection