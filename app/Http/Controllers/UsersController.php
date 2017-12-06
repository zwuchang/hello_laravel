<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Faker;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',[
            'except'    =>  ['index','show','create','store']
        ]);

        //只让未登录用户访问注册页
        $this->middleware('guest',[
            'only'  => ['create']
        ]);
    }

    /**
     * 用户列表
     */
    public function index()
    {
        $users = User::paginate(7);
        return view('users.index',compact('users'));
    }

    /**
     * @param User $user
     * 用户信息
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * 编辑用户信息
     * @param User $user
     */
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $updData = [
            'name'  =>  $request->name
        ];
        $validateArr = [
            'name'  =>  'required|max:50'
        ];
        if (!empty($request->password)){
            $updData['password'] = bcrypt($request->password);
            $validateArr['password'] = 'required|confirmed|min:6';
        }

        $this->authorize('update',$user);

        $this->validate($request,$validateArr);
        $user->update($updData);
        session()->flash('success','更新成功');
        return redirect()->route('users.show',$user->id);

    }

    //删除用户
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
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

        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~！');
        return redirect()->route('users.show',[$user]);
    }



}
