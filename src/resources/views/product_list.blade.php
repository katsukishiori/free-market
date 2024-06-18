@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_list.css') }}">
@endsection

@section('content')

<body>
    <div class="area">
        <div class="tab-container">
            <input type="radio" name="tab_name" id="tab1" checked>
            <label class="tab_class" for="tab1">おすすめ</label>
            <input type="radio" name="tab_name" id="tab2">
            <label class="tab_class" for="tab2">マイリスト</label>
        </div>

        <div class="content_class" id="content1">
            <div class="image-container">
                @foreach ($items as $item)
                <a href="{{ route('item.detail', ['item_id' => $item->id]) }}">
                    <img src="{{ asset('storage/images/' . $item->img_url) }}" alt="{{ $item->name }}の画像">
                </a>
                @endforeach
            </div>
        </div>

        <div class="content_class" id="content2">
            <div class="image-container">
                @foreach ($items as $item)
                <?php
                // アイテムがいいねされているかをチェック
                $isLiked = $item->likes()->where('user_id', auth()->id())->exists();
                ?>
                @if($isLiked)
                <a href="{{ route('item.detail', ['item_id' => $item->id]) }}">
                    <img src="{{ asset('storage/images/' . $item->img_url) }}" alt="{{ $item->name }}の画像">
                </a>
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
    @endsection
</body>