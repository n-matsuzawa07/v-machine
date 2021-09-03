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
              @foreach($companies as $company)
              <option value="">{{ $company->company_name }}</option>
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
          <td></td>
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