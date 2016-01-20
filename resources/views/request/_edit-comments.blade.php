


@foreach($request->Comments as $comment)

    <div class="media">
        <div class="media-body">
            <h4 class="media-heading">{!! $comment->comment !!}</h4>
            {!! $comment->author->name !!} @ {!! $comment->created_at !!}

        </div>
    </div>
@endforeach