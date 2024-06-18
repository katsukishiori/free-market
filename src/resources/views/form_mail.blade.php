<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACH TECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form_mail.css') }}">

    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>


    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <div class="address__content">
        <div class="address-form__heading">
            <h2>ユーザーへメール送信</h2>
        </div>

        <form class="form" action="{{ route('send.mail') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">宛先メールアドレス</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                    </div>
                    <div class="form__error">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">件名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control">
                    </div>
                    <div class="form__error">
                        @error('subject')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">本文</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <textarea name="body" cols="50" rows="5" class="form-control">{{ old('body') }}</textarea>
                    </div>
                    <div class="form__error">
                        @error('body')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit btn btn-primary" type="submit">メールを送信する</button>
            </div>
        </form>
    </div>

</body>