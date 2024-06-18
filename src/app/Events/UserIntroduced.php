<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Events\User;
use App\UserIntroduction;


class UserIntroduced
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $introduced_user, User $registered_user)
    {
        // 友達紹介「した」ユーザーの処理
        $introduced_user->save();

        // 友達紹介「された」ユーザーの処理
        $registered_user->save();

        // 紹介情報を保存
        $user_introduction = new \App\UserIntroduction();
        $user_introduction->introduced_user_id = $introduced_user->id;
        $user_introduction->registered_user_id = $registered_user->id;
        $user_introduction->save();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
