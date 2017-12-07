<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }

    /**
     * 一个用户拥有多条微博
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * https://en.gravatar.com/
     * @param int $size
     */
    public function gravatar($size = 100)
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * 用户微博信息
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feed()
    {
        $user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids,Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)
                            ->with('user')
                            ->orderBy('created_at','desc');
    }

    /**
     * 粉丝列表
     */
    public function followers()
    {
        return $this->belongsToMany(User::Class,'followers','user_id','follower_id');
    }

    /**
     * 关注列表
     */
    public function followings()
    {
        return $this->belongsToMany(User::Class,'followers','follower_id','user_id');
    }

    /**
     * 关注某人
     * @param $user_ids
     */
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $this->followings()->sync($user_ids,false);
    }

    /**
     * 取消关注
     */
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $this->followings()->detach($user_ids);
    }

    /**
     * 是否关注
     */
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }


}





























