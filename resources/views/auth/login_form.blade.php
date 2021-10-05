@extends('layout')
@section('title','ログイン')
@section('content')
  <div class="">
    <!-- <form action="{{route('login')}}" method="POST"> -->
    <h2 class="">ユーザーログイン画面</h2>

    <!-- エラー表示 -->
    @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if(session('login_error'))
    <div class="alert alert-danger">
      {{session('login_error')}}
    </div>
    @endif

    <form action="{{route('login')}}" method="POST">
      @csrf
      <div>
        <span>メールアドレス</span><input type="email" name="email">
      </div>
      <div>
        <span>パスワード</span><input type="password" name="password">
        @error('password')
        <span><strong>{{ $message }}</strong></span>
        @enderror
      </div>
      <button class="m-auto" type="submit">ログイン</button>
      <div>
        <p>新規登録の方は下記より登録をお願いします</p>
      </div>
      <button type="button"><a href="{{route('showUserCreate')}}">新規登録</a></button>
    </form>
  </div>
@endsection