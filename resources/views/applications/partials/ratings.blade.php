@inject('user_rep', 'App\Repositories\UserRepository')

<section id="app__ratings" class="ratings">
    <h4 class="heading--border">
        Avg. Rating 
        <span class="pull-right">
            @for($i = 1; $i <= $application->rating; $i++)
                <i class="fa fa-star"></i>

                @if ( worthyOfHalfStar($application->rating, $i) )
                    <i class="fa fa-star-half-o"></i>
                @endif
            @endfor
        </span>
    </h4>
    <ul class="list-unstyled">
        @permission('create.ratings')
            <li class="rating--auth">
                <span class="rating__user">Me</span>
                @include('applications.partials.ratings-form')
            </li>
        @endpermission
        @foreach ($user_rep->reviewers() as $user)
            @unless($user->id == Auth::id())
            <li class="rating--guest">
                @if ($application->hasRatingByUser($user->id))
                    <span class="rating__user" data-user-rating="{{$application->ratingByUser($user->id)}}">{{$user->name}}</span>
                    @for ($i = 1; $i <= $application->ratingByUser($user->id); $i++)
                        <i class="fa fa-star"></i>
                    @endfor
                @else
                    <span class="rating__user">{{$user->name}}</span>
                    Unrated
                @endif
            </li>
            @endunless
        @endforeach
        @permission('assign.reviewers')
            <br>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                Assign Reviewers
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Assign Reviewers</h4>
                        </div>
                        <div class="modal-body">
                            @foreach(App\Repositories\UserRepository::reviewers() as $reviewer)
                                <div>{{$reviewer->name}}</div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        @endpermission
    </ul>
</section>