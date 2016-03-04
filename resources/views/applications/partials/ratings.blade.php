<div class="col-md-5 submission-ratings">
    <div class="inner">
        <section id="app__ratings" class="ratings">
            <ul class="list-unstyled">
                <li>
                    <span class="rating__user">Me</span>
                    @include('applications.partials.ratings-form')
                </li>
                @foreach (\App\User::all() as $user)
                    <li>
                        <span class="rating__user">{{$user->name}}</span>
                        @if ($application->hasRatingByUser($user->id))
                            @for ($i = 1; $i <= $application->ratingByUser($user->id); $i++)
                                <i class="fa fa-star"></i>
                            @endfor
                        @else
                            Unrated
                        @endif
                    </li>
                @endforeach
            </ul>
        </section>
        <section class="comments">
            <textarea name="comment" id="comment" rows="10"></textarea>
            <h4>All Comments</h4>
            <ul class="list-unstyled">
                <li>
                    <p><strong>Scott</strong></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque tempore quasi mollitia velit similique odio id voluptatem dolore quae, necessitatibus corrupti maxime inventore dolores quam voluptates veniam, eveniet culpa alias?</p>
                </li>
                <li>
                    <p><strong>David</strong></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque tempore quasi mollitia velit similique odio id voluptatem dolore quae, necessitatibus corrupti maxime inventore dolores quam voluptates veniam, eveniet culpa alias?</p>
                </li>
                <li>
                    <p><strong>Ronda</strong></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque tempore quasi mollitia velit similique odio id voluptatem dolore quae, necessitatibus corrupti maxime inventore dolores quam voluptates veniam, eveniet culpa alias?</p>
                </li>
                <li>
                    <p><strong>Sheena</strong></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque tempore quasi mollitia velit similique odio id voluptatem dolore quae, necessitatibus corrupti maxime inventore dolores quam voluptates veniam, eveniet culpa alias?</p>
                </li>
            </ul>
        </section>
    </div>
</div>