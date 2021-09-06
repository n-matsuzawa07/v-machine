@extends('layout')
@section('title','商品一覧')
@section('content')
<div class="row">
  <div class="">

    <h2 class="">商品一覧</h2>
    @if(session('err_msg'))
    <p class="text-danger">
      {{session('err_msg')}}
    </p>
    @endif
    <div>
      <ul>
        <li>名前：{{Auth::user()->name}}</li>
        <li>メールアドレス：{{Auth::user()->email}}</li>
      </ul>
    </div>

    <!--  検索フォーム  -->
    <form method="GET" action="{{url('/product/list')}}">
      @csrf
      <span>商品名</span>
      <input type="text" name="keyword" value='{{$keyword}}'>
      <span>メーカー</span>
      <select class="" name="keyword2">
        <option style="display:none">選択してください</option>
        @foreach($companies as $company)
        <option value="">{{ $company->company_name }}</option>
        @endforeach
      </select>
      <span class=""><input type="submit" value="検索"></span>
    </form>

    <span class="d-block float-right"><button ><a class="text-dark" href="{{route('create')}}">新規登録</a></button></span>

    <table class="table table-striped">
      <tr>
        <th>ID</th>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫数</th>
        <th>メーカー名</th>
        <th></th>
        <th></th>
      </tr>
      @foreach($products as $product)
      <tr>
        <td>{{ $product->id }}</td>
        <td class="" style="text-align:center">
          <img src="/storage/{{$product->image}}" class="" style="height:100px">
        </td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->companies->company_name}}</td>
        <td><button type="button"><a class="text-dark" href="/product/{{ $product->id }}">詳細</a></button></td>
        <form action="{{route('delete', $product->id)}}" method="POST" onSubmit="return checkDelete()">
          @csrf
          <td><button type="submit"><a class="text-dark">削除</a></button></td>
        </form>
      </tr>
      @endforeach
    </table>
  </div>
</div>
<script>
function checkDelete() {onSubmit="return checkSubmit()"
  if (window.confirm('削除してもよろしいですか？')) {
    return true;
  } else {
    return false;
  }
}
</script>
@endsection