@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manager.css') }}">
@endsection

@section('content')

<body>
    <div class="container">
        <h1 class="manager-title">
            ショップスタッフ招待メール送信
        </h1>

        <div class="card my-4 shadow-sm">
            <div class="card-body">


                @if (session('status'))
                <div class="card-text alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('invite.email') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" type="email" id="email" name="email" required placeholder="メールアドレスを入力" value="{{ old('email') }}" {{ Auth::id() === config('const.GUEST_USER_ID') ? 'readonly' : '' }}>
                        <p>※招待したいショップスタッフのメールアドレスを入力してください。</p>
                    </div>

                    @if (Auth::id() !== config('const.GUEST_USER_ID'))
                    <button type="submit" class="submit-btn">
                        <b>送信する</b>
                    </button>
                    @endif
                </form>
            </div>
        </div>
        <a class="bottom__btn " href="{{ route('manager.detail') }}">ショップスタッフ一覧へ</a>
    </div>

</body>

@endsection