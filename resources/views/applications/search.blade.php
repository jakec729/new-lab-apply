@extends('layouts.submission')

@section('title', $page_title)

@section('body')
	@include('applications.partials.table-nofilter')
@endsection

@section('controls')
	@include ('applications.partials.controls')
@endsection