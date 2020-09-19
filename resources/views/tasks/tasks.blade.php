@if (count($tasks) > 0)
    <ul class="list-unstyled">
        @foreach ($tasks as $task)

                <div class="media-body">
                   
                    <div>
                        {{-- ユーザ詳細ページへのリンク --}
                      {!! link_to_route('tasks.show', $task->user->name, ['user' => $task->user->id]) !!}
                        <span class="text-muted">posted at {{ $task->created_at }}</span>
                    </div>
                    <div>
                        @if (Auth::id() == $tasks->user_id)
                            {{-- 投稿削除ボタンのフォーム --}}
                            {!! Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                     
                </div>
               
            </li>
          
        @endforeach
         </ul>
    {{-- ページネーションのリンク --}}
    {{ $users->links() }}

@endif