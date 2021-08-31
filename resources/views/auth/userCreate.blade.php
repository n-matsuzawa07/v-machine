@extends('layout')
@section('title','ユーザー新規登録')
@section('content')
<div class="row">
  <div class="">
    <form action="{{route('register')}}" method="POST">
      <h2 class="">ユーザー新規登録</h2>

      @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
          <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST action=" {{route('register')}}"">
        @csrf
        <div>
          <span>ユーザー名</span><input type="text" name="userName">
        </div>
        <div>
          <span>メールアドレス</span><input type="email" name="email">
        </div>
        <div>
          <span>パスワード</span><input type="password">
        </div>
        <div>
          <span>パスワード（確認）</span><input type="password">
        </div>
        <button type="submit">登録</button>
        <button type="button"><a href="{{route('showLogin')}}">戻る</a></button>
      </form>
  </div>
</div>
@endsection