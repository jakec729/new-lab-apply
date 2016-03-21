<form action="{{url("/applications/{$application->id}/rate")}}" method="POST" class="star-rating {{ ($application->alreadyRated()) ? "rated" : null }}">
    {{ csrf_field() }}

    @if($application->alreadyRated())
    <label class="label-remove">
        <input type="radio" name="rating" value="remove" onclick="submit()">
        Undo
    </label>
    @endif

    <label class="label-reject {{ ($application->alreadyRated() && $application->userRating == 0) ? "selected" : null }}">
        <input type="radio" name="rating" value="0" onclick="submit()">
        <i class="fa fa-close"></i>
    </label>

    <label class="label-star {{ ($application->alreadyRated() && $application->userRating >= 5) ? "selected" : null }}">
        <input type="radio" name="rating" value=5 onclick="submit()">
        <i class="fa fa-star"></i>
    </label>

    <label class="label-star {{ ($application->alreadyRated() && $application->userRating >= 4) ? "selected" : null }}">
        <input type="radio" name="rating" value=4 onclick="submit()">
        <i class="fa fa-star"></i>
    </label>

    <label class="label-star {{ ($application->alreadyRated() && $application->userRating >= 3) ? "selected" : null }}">
        <input type="radio" name="rating" value=3 onclick="submit()">
        <i class="fa fa-star"></i>
    </label>

    <label class="label-star {{ ($application->alreadyRated() && $application->userRating >= 2) ? "selected" : null }}">
        <input type="radio" name="rating" value=2 onclick="submit()">
        <i class="fa fa-star"></i>
    </label>

    <label class="label-star {{ ($application->alreadyRated() && $application->userRating >= 1) ? "selected" : null }}">
        <input type="radio" name="rating" value=1 onclick="submit()">
        <i class="fa fa-star"></i>
    </label>
</form>
