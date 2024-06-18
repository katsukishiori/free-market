@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/update_profile.css') }}">

@endsection

@section('content')

@if(Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif
<form class="form" action="/mypage/profile" method="post" enctype="multipart/form-data">
    @csrf
    <div class="profile-title">
        <h1>プロフィール設定</h1>
    </div>

    <div class="user-image">
        <figure class="icon-circle">
            <img id="imagePreview" src="{{ asset('storage/images/' . ($imgUrl ?? 'default.jpg')) }}" alt="プロフィール画像">
        </figure>
        <input type="file" id="fileInput" name="image" onchange="updateFileName()">
        <label for="fileInput" class="custom-file-label" id="fileLabel">画像を選択する</label>
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

    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">ユーザー名</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}">
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
            <span class="form__label--item">郵便番号</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" name="postcode" value="{{ old('postcode', $profile->postcode ?? '') }}">
            </div>
            <div class="form__error">
                @error('postcode')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>

    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">住所</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}">
            </div>
            <div class="form__error">
                @error('address')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>

    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">建物名</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" name="building" value="{{ old('building', $profile->building ?? '') }}">
            </div>
            <div class="form__error">
                @error('building')
                {{ $message }}
                @enderror
            </div>
        </div>
    </div>

    <div class="form__button--renew">
        <button class="form__button-submit" type="submit">更新する</button>
    </div>
</form>

</body>

@endsection