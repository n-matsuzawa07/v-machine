@extends('layout')
@section('title','商品編集')
@section('content')
  <div class="">
    <h2 class="">{{ $product->product_name }}</h2>
    <table class="table table-striped table-layout">
      <tr>
        <th>商品情報ID</th>
        <td>{{$product->id}}</td>
      </tr>
      <tr>
        <th>商品画像</th>
        <td style="text-align:center"><img src="/storage/{{$product->image}}" class="" style="height:100px"></td>
      </tr>
      <tr>
        <th>商品名</th>
        <td>{{$product->product_name}}</td>
      </tr>
      <tr>
        <th>メーカー</th>
        <td>{{$product->companies->company_name}}</td>
      </tr>
      <tr>
        <th>価格</th>
        <td>{{$product->price}}</td>
      </tr>
      <tr>
        <th>在庫数</th>
        <td>{{$product->stock}}</td>
      </tr>
      <tr>
        <th>コメント</th>
        <td>{{$product->comment}}</td>
      </tr>
    </table>
    <button class="btn btn-primary" type="button" onclick="location.href='/product/edit/{{$product->id}}'">編集</button>
    <button class="btn btn-outline-primary ml-3" type=" button" onclick="location.href='{{route('productList')}}'">戻る</button>
  </div>
@endsection