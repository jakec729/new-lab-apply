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
            <button class="btn btn-sm btn-default">Assign Reviewers</button>
        @endpermission
    </ul>
</section>