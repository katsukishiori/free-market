<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACH TECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">

    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <div class="left-section">
                    <a class="header__logo" href="/">
                        COACHTECH
                    </a>
                    <div class="form__input--text">
                        <input type="password" name="password" placeholder="なにをお探しですか?" />
                    </div>
                </div>
                <div class="right-section">
                    <nav class="nav">
                        <ul class="header-nav">
                            @guest <!-- ログインしていない場合に表示 -->
                            <li class="header-nav__item">
                                <a class="header-nav__link--login" href="/login">ログイン</a>
                            </li>
                            <li class="header-nav__item">
                                <a class="header-nav__link--register" href="/register">会員登録</a>
                            </li>
                            <li class="header-nav__item">
                                <a class="header-nav__link--item" href="/sell">出品</a>
                            </li>
                            @else <!-- ログインしている場合に表示 -->
                            <li class="header-nav__item">
                                <form class="form" action="/logout" method="post">
                                    @csrf
                                    <button class="header-nav__button">ログアウト</button>
                                </form>
                            </li>
                            <li class="header-nav__item">
                                <a class="header-nav__link--mypage" href="/mypage">マイページ</a>
                            </li>
                            <li class="header-nav__item">
                                <a class="header-nav__link--item" href="/sell">出品</a>
                            </li>
                            @endguest
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <body>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="flex">
            <div class="box__left">
                <table border="1" class="item-top">
                    <tr>
                        <th rowspan="3">
                            <div class="image-container">
                                <img src="{{ asset('storage/images/' . $item->img_url) }}" alt="{{ $item->name }}の画像">
                            </div>
                        </th>
                        <td>
                            <div class="item-name">
                                <h1>{{ $item->name }}</h1>
                            </div>
                            <div class="item-price">
                                <p>¥{{ number_format($item->price) }}</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="content">
                    <div class="content-item">
                        <p>支払い方法</p>
                        <a class="change-btn" href="#">変更する</a>
                    </div>
                    <div class="content-item">
                        <p>配送先</p>
                        <a class="change-btn" href="/purchase/address/{{ $item->id }}">変更する</a>
                    </div>
                </div>
            </div>
            <div class="box__right">
                <table class="purchase">
                    <tr>
                        <th>商品代金</th>
                        <td>¥{{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <th>支払い金額</th>
                        <td>¥{{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td>コンビニ払い</td>
                    </tr>
                </table>
                <div class="form__button">
                    <form action="{{ route('purchase', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="form__button-submit">購入する</button>
                    </form>
                </div>

            </div>
    </body>

</html>