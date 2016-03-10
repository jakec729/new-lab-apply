@if(is_a($applications, 'Illuminate\Pagination\LengthAwarePaginator'))
    <div>@include('applications.partials.pagination')</div>
    <div>{!! $applications->links() !!}</div>
@endif
<div>
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
    <div>
        <a href="{{url("/files/import")}}" class="btn btn-primary">Import CSV</a>
    </div>
@endif