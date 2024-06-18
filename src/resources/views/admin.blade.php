@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')

<script>
    function confirmDeletion(event) {
        if (!confirm('本当に削除しますか？')) {
            event.preventDefault();
        }
    }
</script>

<body>
    <div class="container">
        <div class="admin__title">
            <h1>ユーザーリスト</h1>
        </div>

        <a class="top-btn" href="{{ route('admin.messages') }}">コメント一覧へ</a>

        <table border="1">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>作成日</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>

                        <a href="{{ route('admin.mail', ['user_id' => $user->id]) }}">メール作成</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.delete', $user->id) }}" method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

@endsection