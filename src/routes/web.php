<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('product_list');
});
Route::get('/', [ItemController::class, 'index']);

// role_id が 1 のユーザーがアクセスできるルート
Route::middleware(['auth', 'checkRole:1'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
    Route::get('/admin/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::get('/admin/mail/{user_id}', [AdminController::class, 'mail'])->name('admin.mail');
    Route::post('/admin/mail', [AdminController::class, 'send'])->name('send.mail');
});

// role_id が 2 のユーザーがアクセスできるルート
Route::middleware(['auth', 'checkRole:2'])->group(function () {
    Route::get('/manager/index', [ManagerController::class, 'index'])->name('manager');
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/invited/{token}', [ManagerController::class, 'showInvitedUserRegistrationForm'])->name('invited');
        Route::post('/invited/{token}', [ManagerController::class, 'registerInvitedUser'])->name('invited.post');
    });
    Route::get('/invited', [ManagerController::class, 'showLinkRequestForm'])->name('invite')->middleware('auth');
    Route::post('/invited', [ManagerController::class, 'sendInviteManagerEmail'])->name('invite.email')->middleware('auth');
    Route::get('/manager/detail', [ManagerController::class, 'detail'])->name('manager.detail');
    Route::delete('/manager/delete/{id}', [ManagerController::class, 'delete'])->name('manager.delete');
});

// 認証不要のルート
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/item/{item_id}', [ItemController::class, 'detail'])->name('item.detail');

Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'index']);
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('purchase');
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])->name('update.address');
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/profile', [UserController::class, 'profile']);
    Route::post('/mypage/profile', [UserController::class, 'updateProfile']);
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.update.address');
    Route::post('/item/like/{item_id}', [LikeController::class, 'create'])->name('like');
    Route::post('/item/unlike/{item_id}', [LikeController::class, 'destroy'])->name('unlike');
    Route::get('/item/comment/{id}', [CommentController::class, 'index']);
    Route::post('/item/comment/{item_id}', [CommentController::class, 'create'])->name('comment');
    Route::delete('/item/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::get('/sell', [ItemController::class, 'sellView']);
    Route::post('/sell', [ItemController::class, 'sellCreate'])->name('sell.create');

    Route::get('/test-sanitize', function () {
        if (function_exists('sanitize_br')) {
            return 'Function sanitize_br exists!';
        } else {
            return 'Function sanitize_br does NOT exist!';
        }
    });
});
