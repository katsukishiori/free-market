<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACH TECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register_invited.css') }}">

    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="register__content">
        <div class="register-form__heading">
            <h2>フリーマーケットアプリへようこそ！</h2>
            <p>下記から登録してください</p>
        </div>

        <form class="form" method="POST" action="{{ route('register.invited', ['token' => $token]) }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">ショップ名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="shop_name" value="{{ old('shop_name') }}" />
                    </div>
                    <div class="form__error">
                        @error('shop_name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">メールアドレス</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="email" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">パスワード</span>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="password" name="password" />
                    </div>
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">確認用パスワード</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="password" name="password_confirmation" class="password" />
                        <div class="form__error">
                            @error('password_confirmation')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="form__button-submit">登録</button>

        </form>
</body>