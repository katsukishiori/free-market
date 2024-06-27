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
use App\Models\Invite;
use App\Mail\InviteManagerMail;
use Illuminate\Support\Facades\Mail;


class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:2');
    }

    // 店舗管理者ページ表示
    public function index()
    {
        $users = User::all();
        return view('manager', compact('users'));
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
            // Invitesテーブルにデータを保存
            Invite::create([
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
        } catch (\Exception $e) {
            // トランザクションロールバック
            DB::rollBack();
            return redirect()->back()->with('status', '招待メールを送信しました!');
        }
    }



    // 招待されたユーザーの登録画面表示
    public function showInvitedUserRegistrationForm($token)
    {
        $invitation = Invite::where('token', $token)->firstOrFail();
        return view('auth.register_invited', ['token' => $token]);
    }

    // 招待されたユーザーの登録機能
    public function registerInvitedUser(Request $request, $token)
    {
        $rules = [
            'shop_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];

        $request->validate($rules);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $manager = Manager::create([
            'shop_name' => $request->input('shop_name'),
            'user_id' => $user->id,
        ]);

        $role = Role::find(2);
        $user->roles()->attach($role->id, ['manager_id' => $manager->id]);

        session()->flash('success', '登録されました！');

        return view('auth.register_invited', ['token' => $token]);
    }

    // ショップスタッフ一覧ページ
    public function detail()
    {
        $managers = Manager::all();
        return view('manager_list', compact('managers'));
    }

    // ショップスタッフ削除機能
    public function delete($id)
    {
        $manager = Manager::findOrFail($id);

        $manager->delete();

        return redirect()->route('manager')->with('success', 'ユーザーを削除しました。');
    }
}
