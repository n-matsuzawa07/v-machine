@extends('layout')
@section('title','商品新規登録')
@section('content')
  <div>
    <h2 class="">商品新規登録</h2>
        @if(session('err_msg'))
    <p class="text-danger">
      {{session('err_msg')}}
    </p>
    @endif
    <form action="{{route('store')}}" method="POST" onSubmit="return checkSubmit()"enctype="multipart/form-data">
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
              <option value="desabled" style="display:none">選択してください</option>
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
          </td>
        </tr>
      </table>
      <button type="submit" class="btn btn-primary">登録</button>
      <button type="button" onclick="location.href='{{route('productList')}}'" class="btn btn-outline-primary ml-3">戻る</button>
    </form>
  </div>
<script>
function checkSubmit() {onSubmit="return checkSubmit()"
  if (window.confirm('登録してもよろしいですか？')) {
    return true;
  } else {
    return false;
  }
}
</script>
@endsection