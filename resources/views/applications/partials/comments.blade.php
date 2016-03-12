<section class="comments">
    <form action="{{url("/applications/{$application->id}/comments")}}" method="POST" class="comments__form">
        {{ csrf_field() }}
        <input type="hidden" name="application_id" value="{{$application->id}}">
        <textarea name="comment" id="comment" rows="10" placeholder="Add a comment..."></textarea>
        <button class="btn btn-default">Add Comment</button>
    </form>
    @include("common.errors")
    <h4 class="heading--border">All Comments</h4>
    @if($application->comments->count() > 0)
    <ul class="list-unstyled">
        @foreach($application->comments as $comment)
            <li class="comment">
                <p class="comment__author">{{$comment->user->name}}</p>
                <p class="comment__text">{{$comment->body}}</p>
            </li>
        @endforeach
    </ul>
    @endif
</section>