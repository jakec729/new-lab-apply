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
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-check"></i></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            @foreach(App\Repositories\UserRepository::reviewers() as $reviewer)
                                <tr>
                                    <td><input type="checkbox" name="users[]" id="input_user_{{$reviewer->id}}" value="{{$reviewer->id}}"></td>
                                    <td>{{$reviewer->name}}</td>
                                    <td>{{$reviewer->email}}</td>
                                </tr>
                            @endforeach
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Confirm">
                </div>
            </form>
        </div>
    </div>
</div>