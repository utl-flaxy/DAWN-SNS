<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'icon_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 自分がフォローしているユーザー（= followings）
     * follows.following_user_id = 自分
     * follows.followed_user_id  = 相手
     */
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'following_user_id',
            'followed_user_id'
        )->withTimestamps();
    }

    /**
     * 自分をフォローしているユーザー（= followers）
     * follows.followed_user_id  = 自分
     * follows.following_user_id = 相手
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'followed_user_id',
            'following_user_id'
        )->withTimestamps();
    }

    public function isFollowing(int $userId): bool
    {
        return $this->followings()->where('users.id', $userId)->exists();
    }

    /**
     * アイコンURL（未設定ならデフォルト画像）
     * - storage/app/public/icons/... に保存したものを public/storage/... で参照
     */
    public function iconUrl(): string
    {
        if (!empty($this->icon_path)) {
            return asset('storage/' . ltrim($this->icon_path, '/'));
        }

        // ここは実在するデフォルト画像に合わせてOK（無ければ作って置いてね）
        return asset('assets/icons/user.png');
    }
}
