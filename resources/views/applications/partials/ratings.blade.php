<div class="col-md-5 submission-ratings">
    <div class="inner">
        <section id="app__ratings" class="ratings">
            <ul class="list-unstyled">
                <li>
                    <span class="rating__user">Me</span>
                    <form action="" method="POST" class="star-rating">
                        {{ csrf_field() }}
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="">
                                <input type="radio" name="rating" value="{{$i}}" onclick="submit()">
                                <i class="fa fa-star"></i>
                            </label>
                        @endfor
                    </form>
                </li>
                <li>
                    <span class="rating__user">Dan</span>
                    <span class="rating__value stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </span>
                </li>
                <li>
                    <span class="rating__user">Jake</span>
                    <span class="rating__value stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </span>
                </li>
                <li>
                    <span class="rating__user">Cait</span>
                    <span class="rating__value stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </span>
                </li>
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