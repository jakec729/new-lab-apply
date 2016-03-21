@if(is_a($applications, 'Illuminate\Pagination\LengthAwarePaginator'))
    <div class="hidden-md hidden-lg hidden-xl">
        @if($applications->previousPageUrl())
            <a href="{{$applications->previousPageUrl()}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>&ensp;Prev</a>
        @endif
        @if($applications->nextPageUrl())
            <a href="{{$applications->nextPageUrl()}}" class="btn btn-primary">Next&ensp;<i class="fa fa-arrow-right"></i></a>
        @endif
    </div>
    <div>@include('applications.partials.pagination')</div>
    <div class="hidden-xs hidden-sm">{!! $applications->links() !!}</div>
@endif
<div class="hidden-xs hidden-sm">
    <form action="/applications/download" method="POST" class="form-inline">
        {{csrf_field()}}
        <div class="form-group">
            <select name="applications_filter" id="applications_filter" class="form-control" onchange='this.form.submit()'>
                <option value="0" selected disabled>Download CSV</option>
                <option value="all">All Submissions</option>
                <option value="shortlisted">Shortlisted</option>
            </select>
        </div>
    </form>
</div>
@if(Auth::user()->hasRole('admin'))
    <div class="hidden-xs hidden-sm">
        <a href="{{url('/applications/deleteAll')}}" class="btn btn-primary" data-confirm>Clear Database</a>
    </div>
    <div class="hidden-xs hidden-sm">
        <a href="{{url("/files/import")}}" class="btn btn-primary">Import CSV</a>
    </div>
@endif