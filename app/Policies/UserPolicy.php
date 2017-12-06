<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //更新策略
    public function update(User $currentUser,User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * 只有管理员才能删除其它用户，管理员不能被删除
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function destroy(User $currentUser,User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
