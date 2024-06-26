@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<body>
    <div class="user-profile">
        <div class="user-info">
            <div class="user-name">
                <figure class="icon-circle">
                    @if ($imgUrl)
                    <img src="{{ asset('storage/images/' . $imgUrl) }}" alt="">
                    @else
                    <div class="default-img"></div>
                    @endif
                </figure>
                @if (Auth::check())
                <h1>{{ Auth::user()->name }}</h1>
                @endif
            </div>
            <a href="/mypage/profile">
                <button class="edit-profile-button">プロフィールを編集</button>
            </a>
        </div>
    </div>

    <div class="area">
        <div class="tab-container">
            <input type="radio" name="tab_name" id="tab1" checked>
            <label class="tab_class" for="tab1">出品した商品</label>
            <input type="radio" name="tab_name" id="tab2">
            <label class="tab_class" for="tab2">購入した商品</label>
        </div>

        <div class="content_class" id="content1">
            <div class="image-container">
                @foreach($items as $item)
                <div>
                    <a href="{{ route('item.detail', ['item_id' => $item->id]) }}">
                        <img src="{{ asset('storage/images/' . $item->img_url) }}" alt="{{ $item->name }}の画像">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="content_class" id="content2">
            <div class="image-container">
                @foreach($soldItems as $soldItem)
                @if ($soldItem->item)
                <div>
                    <a href="{{ route('item.detail', ['item_id' => $soldItem->item->id]) }}">
                        <img src="{{ asset('storage/images/' . $soldItem->item->img_url) }}" alt="{{ $soldItem->item->name }}の画像">
                    </a>
                </div>
                @else
                <p>関連するアイテムが見つかりません。</p>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab_class');
            const contents = document.querySelectorAll('.content_class');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const target = this.getAttribute('for');

                    contents.forEach(content => {
                        content.style.display = 'none';
                    });

                    document.getElementById(`content${target.charAt(target.length - 1)}`).style.display = 'block';
                });
            });
        });
    </script>

    <div class="content_class">
        <div class="image-container">
            @foreach($items as $item)
            <div>
                <a href="{{ route('item.detail', ['item_id' => $item->id]) }}">
                    <img src="{{ asset('storage/images/' . $item->img_url) }}" alt="{{ $item->name }}の画像">
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="content_class">
        <div class="image-container">
            @foreach($soldItems as $soldItem)
            @if ($soldItem->item) <!-- 関連する item が存在する場合のみ表示 -->
            <div>
                <a href="{{ route('item.detail', ['item_id' => $soldItem->item->id]) }}">
                    <img src="{{ asset('storage/images/' . $soldItem->item->img_url) }}" alt="{{ $soldItem->item->name }}の画像">
                </a>
            </div>
            @else
            <p>関連するアイテムが見つかりません。</p>
            @endif
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab_class');
            const contents = document.querySelectorAll('.content_class');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const target = this.getAttribute('for');

                    contents.forEach(content => {
                        content.style.display = 'none';
                    });

                    document.getElementById(`content${target.charAt(target.length - 1)}`).style.display = 'block';
                });
            });
        });
    </script>

    @endsection
</body>