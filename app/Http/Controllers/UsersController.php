<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{

    /**
     * @param User $user
     * 用户信息
     */
    public function show(User $user)
    {
        get_db_config();
        return view('users.show',compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 注册页
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 保存用户注册
     * @param Request $request
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name'  =>  'required|max:50',
            'email' =>  'required|email|unique:users|max:255',
            'password'  =>  'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password'  =>  bcrypt($request->password)
        ]);

        session()->flash('success','欢迎，您将在这里开启一段新的旅程~！');
        return redirect()->route('users.show',[$user]);
    }



}
