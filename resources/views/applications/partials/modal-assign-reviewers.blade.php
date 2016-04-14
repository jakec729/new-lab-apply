<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
    Assign Reviewers
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url("applications/{$application->id}/reviewers")}}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Assign Reviewers</h4>
                </div>
                <div class="modal-body">
                        {{ csrf_field() }}
                        <ul class="list-unstyled">
                            @foreach(App\Repositories\UserRepository::reviewers() as $reviewer)
                                <li><label><input type="checkbox" name="users[]" value="{{$reviewer->id}}">&nbsp;&nbsp;{{$reviewer->name}}</label></li>
                            @endforeach
                        </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>