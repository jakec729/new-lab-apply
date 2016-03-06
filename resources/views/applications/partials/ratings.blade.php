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
        <li class="rating--auth">
            <span class="rating__user">Me</span>
            @include('applications.partials.ratings-form')
        </li>
        @foreach (\App\User::all() as $user)
            @unless($user->id == Auth::id())
            <li class="rating--guest">
                <span class="rating__user">{{$user->name}}</span>
                @if ($application->hasRatingByUser($user->id))
                    @for ($i = 1; $i <= $application->ratingByUser($user->id); $i++)
                        <i class="fa fa-star"></i>
                    @endfor
                @else
                    Unrated
                @endif
            </li>
            @endunless
        @endforeach
    </ul>
</section>