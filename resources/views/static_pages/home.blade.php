@extends('layouts.default')
@section('title','主页')
@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p>
          一切，将从这里开始。
        </p>
        <p class="lead">
            <a target="_blank" href="https://d.laravel-china.org/">Laravel文档中心</a>
        </p>
        <p>
           <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
        </p>
    </div>
@stop