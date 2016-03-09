@extends('layouts.submission')

@section('title', 'All Submissions')

@section('body')
	@include('applications.partials.table')
@endsection

@section('controls')
	@include ('applications.partials.controls')
@endsection