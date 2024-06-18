<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACH TECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">

    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>

    <div class="container">
        <h1 class="message-title">コメント一覧</h1>

        <form class="form" method="GET" action="{{ route('admin.messages') }}" class="search-form">
            <div class="form-group">
                <input type="text" name="user" id="user" class="form-control" placeholder=ユーザー名で検索 value="{{ request('user') }}">
            </div>
            <div class="form-group">
                <input type="text" name="item" id="item" class="form-control" placeholder=商品名で検索 value="{{ request('item') }}">
            </div>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>

        @foreach ($comments as $itemComments)
        @php $item = $itemComments->first()->item; @endphp
        <h2 class="item-name">{{ $item->name }}</h2>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ユーザー名</th>
                    <th>コメント</th>
                    <th>送信日時</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itemComments as $comment)
                <tr>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->comment }}</td>
                    @if($comment->created_at)
                    <td>{{ $comment->created_at->format('Y-m-d H:i') }}</td>
                    @else
                    <td>NULL</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>