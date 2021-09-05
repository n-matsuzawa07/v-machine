@extends('layout')
@section('title','商品編集')
@section('content')
<div class="row">
  <div class="">
    <h2 class="">商品編集</h2>
    @if(session('err_msg'))
    <p class="text-danger">
      {{session('err_msg')}}
    </p>
    @endif
    <form action="{{route('update')}}" method="POST" onSubmit="return checkSubmit()">
      @csrf
      <input type="hidden" name="id" value="{{$product->id}}">
      <table class="table table-striped table-layout">
        <tr>
          <th>商品情報ID</th>
          {{-- <td><input type="text" name="product_id" value="{{$product->id}}" readonly></td> --}}
          <td><p>{{$product->id}}</p></td>
        </tr>
        <tr>
          <th>商品名</th>
          <td><input type="text" name="product_name" value="{{$product->product_name}}"></td>
        </tr>
        <tr>
          <th>メーカー</th>
          <td>
            <select name="company">
              <option value="desabled" style="display:none">{{$product->companies->company_name}}</option>
              @foreach($companies as $company)
              <option>{{ $company->company_name }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <th>価格</th>
          <td><input type="text" name="price" value="{{$product->price}}"></td>
        </tr>
        <tr>
          <th>在庫数</th>
          <td><input type="text" name="stock" value="{{$product->stock}}"></td>
        </tr>
        <tr>
          <th>コメント</th>
          <td><input type="text" name="comment" value="{{$product->comment}}"></td>
        </tr>
        <tr>
          <th>商品画像</th>
          <td>
            <input type="file" name="image" id="image" value="{{$product->image}}" accept="image/png, image/jpeg, image/jpg, image/gif"
              class="form-control-file">
            <img src="/storage/{{$product->image}}" class="" style="height:100px">
          </td>
        </tr>
      </table>
      <button type="submit">更新</button>
      <button type=" button"><a href="{{route('detail',$product->id)}}">戻る</a></button>
    </form>
  </div>
</div>
<script>
function checkSubmit() {
  if (window.confirm('更新してもよろしいですか？')) {
    return true;
  } else {
    return false;
  }
}
</script>
@endsection