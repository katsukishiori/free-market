<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACH TECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">

    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>
</body>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="sell__content">
    <div class="sell-form__heading">
        <h1>商品の出品</h1>
    </div>

    <form class="form" action="{{ route('sell.create') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品画像</span>
                <div class="form__group-content">
                    <div class="form__input--text">

                    </div>
                </div>
                <div class="custom-file-upload">
                    <input type="file" id="fileInput" name="img_url" onchange="updateFileName()">
                    <label for="fileInput" class="custom-file-label" id="fileLabel">画像を選択する</label>
                    <img id="imagePreview" src="" alt="Image Preview" style="display: none; max-width: 100%; height: auto;">
                </div>

                <div class="form__error">
                    @error('img_url')
                    {{ $message }}
                    @enderror
                </div>

                <script>
                    function updateFileName() {
                        var fileInput = document.getElementById('fileInput');
                        var fileLabel = document.getElementById('fileLabel');
                        var fileName = fileInput.files[0] ? fileInput.files[0].name : '画像を選択する';
                        fileLabel.textContent = fileName;

                        var file = fileInput.files[0];
                        if (file) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var imagePreview = document.getElementById('imagePreview');
                                imagePreview.src = e.target.result;
                                imagePreview.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                </script>
            </div>

        </div>


        <div class="form__group">
            <h2>商品の詳細</h2>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">カテゴリー</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <select name="category">
                        <option value="" disabled selected>選択してください</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if(old('category', $user->category_id ?? '') == $category->id) selected @endif>
                            {{ $category->category }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('category')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品の状態</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <select name="condition" id="condition">
                        <option value="" disabled selected>選択してください</option>
                        @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}" @if(old('condition', $user->condition_id ?? '') == $condition->id) selected @endif>
                            {{ $condition->condition }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('condition')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <h2>商品と説明</h2>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{ old('name') }}" />
                </div>
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">商品の説明</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <textarea name="description" cols="50" rows="5">{{ old('description') }}</textarea>
                </div>
                <div class="form__error">
                    @error('description')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <h2>販売価格</h2>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">販売価格</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="price" value="{{ old('price') }}" />
                </div>
                <div class="form__error">
                    @error('price')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>

</div>