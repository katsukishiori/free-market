<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Mail\InviteManagerMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:2');
    }

    public function index()
    {
        $users = User::all();
        return view('manager', compact('users'));
    }

    public function showLinkRequestForm()
    {
        return view('auth.register_invited');
    }

    public function sendInviteManagerEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = Auth::user();
        $email = $request->input('email');
        $token = Str::random(60);

        // トランザクション開始
        DB::beginTransaction();

        try {
            // 招待をデータベースに保存
            Manager::create([
                'user_id' => $user->id,
                'email' => $email,
                'token' => $token,
            ]);

            $invite_url = route('register.invited', ['token' => $token]);

            $message = [
                'title' => 'フリーマーケットアプリへの招待',
                'body' => 'あなたはフリーマーケットアプリへ招待されました!以下のURLをクリックして、登録してください!',
                'invite_url' => $invite_url,
            ];

            // メール送信
            Mail::to($email)->send(new InviteManagerMail($message));

            // トランザクションコミット
            DB::commit();

            return redirect()->back()->with('status', '招待メールを送信しました!');
        } catch (\Exception $e) {
            // トランザクションロールバック
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'メールの送信に失敗しました。']);
        }
    }

    public function showInvitedUserRegistrationForm($token)
    {
        $invitation = Manager::where('token', $token)->firstOrFail();
        return view('auth.register_invited', ['token' => $token]);
    }


    public function registerInvitedUser(Request $request, $token)
    {
        // バリデーションルール
        $rules = [
            'shop_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];

        // バリデーションの実行
        $request->validate($rules);

        // ユーザーを作成
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // マネージャー情報を作成し、そのIDを取得
        $manager = Manager::create([
            'shop_name' => $request->input('shop_name'),
            'user_id' => $user->id, // 必要に応じてマネージャーとユーザーの関連付けを行う
        ]);

        // ユーザーに役割を割り当てる（例えば、role_idが2の役割を割り当てる）
        $role = Role::find(2); // ここで適切な役割IDを指定します
        $user->roles()->attach($role->id, ['manager_id' => $manager->id]);

        session()->flash('success', '登録されました！');
        // リダイレクトやレスポンスを返すなどの適切な処理を追加します
        return view('auth.register_invited', ['token' => $token]);
    }

    public function detail()
    {
        $managers = Manager::all();
        return view('manager_list', compact('managers'));
    }

    public function delete($id)
    {
        $manager = Manager::findOrFail($id);

        // ユーザーを削除
        $manager->delete();

        // リダイレクトして成功メッセージを表示
        return redirect()->route('manager')->with('success', 'ユーザーを削除しました。');
    }
}
