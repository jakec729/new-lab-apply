@inject('user_rep', 'App\Repositories\UserRepository')


<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" id="assignMultipleReviewersBtn" data-target="#assignMultipleReviewersModal">
    Assign Reviewers
</button>

<!-- Modal -->
<div class="modal fade" id="assignMultipleReviewersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url("applications/assignReviewersToApps")}}" method="POST" id="multipleReviewersForm">
                {{csrf_field()}}
                <input type="hidden" value="TEST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Assign Reviewers</h4>
                </div>
                <div class="modal-body">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-check"></i></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            @foreach($user_rep->reviewers() as $reviewer)
                                <tr data-row-select>
                                    <td><input type="checkbox" name="users[]" id="input_user_{{$reviewer->id}}" value="{{$reviewer->id}}"></td>
                                    <td>{{$reviewer->name}}</td>
                                    <td>{{$reviewer->email}}</td>
                                </tr>
                            @endforeach
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Confirm Reviewers">
                </div>
            </form>
        </div>
    </div>
</div>