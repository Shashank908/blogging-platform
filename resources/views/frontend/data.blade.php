@forelse ($posts as $post)
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $post['title'] }} - 
            <small>by 
                @if(isset($post['user_name']))
                    {{ $post['user_name'] }}
                @endif
            </small>

            <span class="pull-right">
                {{ $post['created_at'] }}
            </span>
        </div>

        <div class="panel-body">
            <p>{{ str_limit($post['body'], 200) }}</p>
            
            <p>
                <a href='{{ url("/posts/{$post["id"]}") }}'' class="btn btn-sm btn-primary">See more</a>
            </p>
        </div>
    </div>
@empty
    <div class="panel panel-default">
        <div class="panel-heading">Not Found!!</div>

        <div class="panel-body">
            <p>Sorry! No post found.</p>
        </div>
    </div>
@endforelse