@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<body>
    <div class="flex">
        <div class="box__left">
            <div class="image-container">
                <img src="/img/{{ $item->img_url }}" alt="{{ $item->name }}の画像">
            </div>
        </div>

        <div class="box__right">
            <div class="item-name">
                <h1>{{ $item->name }}</h1>
                <p>COACHTECH</p>
            </div>
            <div class="item-price">
                <p>¥{{ number_format($item->price) }}(値段)</p>
            </div>

            <div class="button-container">
                <form action="{{ route('like', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="like-btn">
                        <i id="heartIcon{{ $item->id }}" class="fa-regular fa-star like-icon" style="color: {{ $item->isLiked ? 'red' : '#' }}"></i>
                        <span class="like-count">{{ $item->likes->count() }}</span>
                    </button>
                </form>

                <script>
                    function toggleFavorite(event, itemId) {
                        event.preventDefault();

                        var heartIcon = document.getElementById('heartIcon' + itemId);
                        var isLiked = heartIcon.style.color === 'red';

                        fetch('/like/toggle/' + itemId, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    isLiked: !isLiked
                                })
                            })
                            .then(response => {
                                if (response.ok) {
                                    // レスポンスが正常な場合、アイコンの色を変更します
                                    heartIcon.style.color = isLiked ? '#EEEEEE' : 'red';
                                    return response.json();
                                }
                                throw new Error('いいねの状態を変更できませんでした');
                            })
                            .then(data => {
                                // 応答データを処理します（必要に応じて）
                            })
                            .catch(error => {
                                console.error('エラーが発生しました:', error);
                            });
                    }
                </script>

                <form action="/item/comment/{{ $item->id }}" method="GET">
                    @csrf
                    <button type="submit" class="comment-btn">
                        <i class="fa-regular fa-comment"></i>
                        <span class="comment-count">{{ $item->comments_count }}</span>
                    </button>
                    </button>
                </form>
            </div>

            @foreach ($comments as $comment)
            <div class="evaluation-item">
                <div class="evaluation-name">
                    <figure class="icon-circle">
                        @if ($comment->user && $comment->user->profile && $comment->user->profile->img_url)
                        <img src="{{ asset('storage/images/' . $comment->user->profile->img_url) }}" alt="">
                        @else
                        <div class="default-img"></div>
                        @endif
                    </figure>
                    <h4>{{ $comment->user->name }}</h4>
                </div>

                <div class="evaluation-comment">
                    {{ $comment->comment }}

                    @if($comment->user_id === Auth::id())
                    <form action="{{ route('comment.destroy', ['item' => $item->id, 'comment' => $comment->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('本当にこのコメントを削除しますか？');">削除</button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach


            <div class="comment">
                <p>商品へのコメント</p>
                <form action="{{ route('comment', ['item_id' => $item->id]) }}" method="post">
                    @csrf
                    <textarea name="comment" cols="40" rows="7"></textarea>
                    <div class="form__error">
                        @error('comment')
                        {{ $message }}
                        @enderror
                    </div>

                    <div class="form__button--comment">
                        <button class="form__button-submit" type="submit">コメントを送信する</button>
                    </div>

                </form>

            </div>
        </div>
</body>

@endsection