@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manager_list.css') }}">
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
        <div class="manager-list__title">
            <h1>ショップスタッフリスト</h1>
        </div>

        <table border="1">
            <thead>
                <tr>
                    <th>ショップ名</th>
                    <th>メールアドレス</th>
                    <th>作成日</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($managers as $manager)
                <tr>
                    <td>{{ $manager->shop_name }}</td>
                    <td>{{ $manager->user->email }}</td>
                    <td>{{ $manager->created_at }}</td>
                    <td>
                        <form action="{{ route('manager.delete', $manager->id) }}" method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a class="bottom__btn" href="{{ route('manager') }}">ショップスタッフ招待メール送信画面へ</a>
    </div>
</body>

@endsection