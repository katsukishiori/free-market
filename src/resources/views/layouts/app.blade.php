<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACH TECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

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

    <main>
        @yield('content')
    </main>

</body>

</html>