@extends('layouts.default')
@section('title','主页')
@section('content')
    @if (Auth::check())
        <div class="row">
            <div class="col-md-8">
                <section class="status_form">
                    @include('shared._status_form')
                </section>
                <h3>微博列表</h3>
                @include('shared._feed')
            </div>
            <aside class="col-md-4">
                <section class="col-md-4">
                    @include('shared._user_info',['user' => Auth::user()])
                </section>
            </aside>
        </div>
    @else
        <div class="jumbotron">
            <h1>Hello Laravel</h1>
            <p>
              一切，将从这里开始。
            </p>
            <p class="lead">
                <a target="_blank" href="https://d.laravel-china.org/">Laravel文档中心</a>
            </p>
            @guest
            <p>
               <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
            </p>
            @endguest
        </div>
    @endif
@stop