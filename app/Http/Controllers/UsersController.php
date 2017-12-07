<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Faker;
use Mail;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',[
            'except'    =>  ['index','show','create','store','confirmEmail']
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
        //微博信息
        $statuses = $user->statuses()
                        ->orderBy('created_at','desc')
                        ->paginate(30);

        return view('users.show',compact('user','statuses'));
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

        $this->sendEmailConfirmationTo($user);
        session()->flash('success','验证邮件已发到您注册邮箱，请注意查收！');
        return redirect('/');
    }

    //发送验证邮件
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = env('MAIL_FULL_NAME');
        $name = 'Aest';
        $to = $user->email;
        $subject = '感谢注册 Sample 应用！请确认您的邮箱。';
        Mail::send($view,$data,function($message) use ($from,$name,$to,$subject) {
            $message->from($from,$name)->to($to)->subject($subject);
        });

    }

    //邮箱验证
    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;

        $user->save();
        Auth::login($user);

        session()->flash('success','恭喜您，激活成功！');
        return redirect()->route('users.show',[$user]);
    }



}






