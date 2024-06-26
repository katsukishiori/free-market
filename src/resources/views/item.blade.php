@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<body>
    <div class="flex">
        <div class="box__left">
            <div class="image-container">
                <img src="{{ asset('storage/images/' . $item->img_url) }}" alt="{{ $item->name }}の画像">
            </div>
        </div>
        <div class="box__right">
            <div class="item-name">
                <h1>{{ $item->name }}</h1>
                @if(isset($roleUser) && $roleUser->manager)
                <p>{{ $roleUser->manager->shop_name }}</p>
                @else
                <p></p>
                @endif
            </div>
            <div class="item-price">
                <p>¥{{ number_format($item->price) }}(値段)</p>
            </div>

            <!--色変える <form action="{{ route('like', ['item_id' => $item->id]) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary like-button" onclick="toggleFavorite(event, '{{ $item->id }}')">
                    <i id="heartIcon{{ $item->id }}" class="fas fa-star" style="color: {{ $item->isLiked ? 'orange' : '#EEEEEE' }}; font-size: 30px;"></i>
                </button>
            </form>
            <span id="likeCount{{ $item->id }}" class="like-count">{{ $item->likes->count() }}</span>

            <script>
                async function toggleFavorite(event, itemId) {
                    event.preventDefault();

                    var heartIcon = document.getElementById('heartIcon' + itemId);
                    var likeCount = document.getElementById('likeCount' + itemId);

                    if (heartIcon.style.color === 'red') {
                        heartIcon.style.color = '#EEEEEE';
                        likeCount.textContent = parseInt(likeCount.textContent) - 1; // カウントを減らす
                        await sendFavoriteStatusToServer(itemId, false);
                    } else {
                        heartIcon.style.color = 'red';
                        likeCount.textContent = parseInt(likeCount.textContent) + 1; // カウントを増やす
                        await sendFavoriteStatusToServer(itemId, true);
                    }
                }

                async function sendFavoriteStatusToServer(itemId, isFavorite) {
                    try {
                        const response = await fetch('/favorites/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                itemId: itemId,
                                isFavorite: isFavorite,
                            }),
                        });

                        if (response.ok) {
                            console.log('お気に入りの状態がサーバーに送信されました');
                        } else {
                            console.error('お気に入りの状態の送信に失敗しました');
                        }
                    } catch (error) {
                        console.error('エラーが発生しました', error);
                    }
                }
            </script> -->
            <div class="button-container">
                <form action="{{ route('like', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="like-btn">
                        <i id="heartIcon{{ $item->id }}" class="fa-regular fa-star like-icon" style="color: {{ $item->isLiked ? 'red' : '#' }}"></i>
                        <span class="like-count">{{ $item->likes->count() }}</span>
                    </button>
                </form>

                <form action="/item/comment/{{ $item->id }}" method="GET">
                    @csrf
                    <button type="submit" class="comment-btn">
                        <i class="fa-regular fa-comment"></i>
                        <span class="comment-count">{{ $item->comments_count }}</span>
                    </button>
                    </button>
                </form>
            </div>

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

            <div class="form__button">
                <a href="/purchase/{{ $item->id }}" class="form__button-submit">購入する</a>
            </div>
            <div class="item-description">
                <h2>商品説明</h2>
                <p>{!! nl2br(e($item->description)) !!}</p>
            </div>
            <div class="item-information">
                <h2>商品の情報</h2>
                <table>
                    <tr>
                        <th>カテゴリー</th>
                        <td>{{ $category->category }}</td>
                    </tr>
                    <tr>
                        <th>商品の状態</th>
                        <td>{{ $item->condition->condition }}</td>
                    </tr>
                </table>
            </div>
        </div>
</body>

@endsection