@extends('layout')
@section('title','商品編集')
@section('content')
<div class="row">
  <div class="">
    @foreach($products as $product)
    <h2 class="">{{ $product->product_name }}</h2>
    <table class="table table-striped table-layout">
      <tr>
        <th>商品情報ID</th>
        <td>{{$product->id}}</td>
      </tr>
      <tr>
        <th>商品画像</th>
        <td></td>
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
    <button type="button"><a href='/product/edit/{{$product->id}}'>編集</a></button>
    <button type=" button"><a href="{{route('productList')}}">戻る</a></button>
    @endforeach
  </div>
</div>
@endsection