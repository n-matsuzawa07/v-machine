@extends('layout')
@section('title','商品新規登録')
@section('content')
<div class="row">
  <div class="">
    <h2 class="">商品新規登録</h2>
    <form action="{{route('store')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <table class="table table-striped table-layout">
        <tr>
          <th>商品名</th>
          <td><input type="text" name="product_name" id="product_name">
            @if($errors->has('product_name'))
            <div class="text-danger">
              {{$errors->first('product_name')}}
            </div>
            @endif
          </td>
        </tr>
        <tr>
        <tr>
          <th>メーカー</th>
          <td>
            <select name="company_id">
              @foreach($companies as $company)
              <option>{{ $company->company_name }}</option>
              @endforeach
            </select>
            @if($errors->has('company_id'))
            <div class="text-danger">
              {{$errors->first('company_id')}}
            </div>
            @endif
          </td>
        </tr>
        <tr>
          <th>価格</th>
          <td><input type="text" name="price" id="price">
            @if($errors->has('price'))
            <div class="text-danger">
              {{$errors->first('price')}}
            </div>
            @endif
          </td>
        </tr>
        <tr>
          <th>在庫数</th>
          <td><input type="text" name="stock" id="stock">
            @if($errors->has('stock'))
            <div class="text-danger">
              {{$errors->first('stock')}}
            </div>
            @endif
          </td>
        </tr>
        <tr>
          <th>コメント</th>
          <td><input type="text" name="comment" id="comment"></td>
        </tr>
        <tr>
          <th>商品画像</th>
          <td>
            <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/jpg, image/gif"
              class="form-control-file">

            <!-- 画像だけを一度アップロードするパターン -->
            <!-- <form method="POST" action="/product/create" enctype="multipart/form-data">
              <input type="file" name="image" class="form-control-file">
              <button type="submit" class="btn btn-primary mt-2">アップロード</button>
            </form> -->

          </td>
        </tr>
      </table>
      <button type="submit">登録</button>
      <button type="button"><a href="{{route('productList')}}">戻る</a></button>
    </form>
  </div>
</div>
@endsection