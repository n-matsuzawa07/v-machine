@extends('layout')
@section('title','商品一覧')
@section('content')
  <div class="col-12">
    <h2>商品一覧</h2>
    @if(session('err_msg'))
    <p class="text-danger">
      {{session('err_msg')}}
    </p>
    @endif
    {{-- <div>
      <ul>
        <li>名前：{{Auth::user()->name}}</li>
        <li>メールアドレス：{{Auth::user()->email}}</li>
      </ul>
    </div> --}}
    <!--  検索フォーム  -->
    <form method="GET" action="{{url('/product/list')}}">
      @csrf
      <span class="font-weight-bold">商品名</span>
      <input type="text" name="keyword" value='{{$keyword}}' class="my-2 mr-4 ml-2">
      <span class="font-weight-bold">メーカー</span>
      <select name="keyword2" class="my-2 mr-4 ml-2">
        <option style="display:none" selected>選択してください</option>
        @foreach($companies as $company)
        <option value="{{$company->company_name}}">
          {{ $company->company_name }}
        </option>
        @endforeach
        {{-- @foreach($products as $product)
        <option value="{{$product->company_id}}">
        <option value="{{$product->companies->id}}">
          {{ $product->companies->company_name }}
        </option>
        @endforeach --}}

        
      </select>
      <span><input type="submit" value="検索" class="btn btn-primary"></span>
    </form>

    <span id="test_jquery" class="d-block float-right"><button class="btn btn-primary" onclick="location.href='{{route('create')}}'">新規登録</button></span>

    <table id="sort_table" class="table table-striped">
      <thead>
        <tr>
          <th>@sortablelink('id','ID')</th>
          <th>@sortablelink('image','商品画像')</th>
          <th>@sortablelink('product_name','商品名')</th>
          <th>@sortablelink('price','価格')</th>
          <th>@sortablelink('stock','在庫数')</th>
          <th>@sortablelink('company_id','メーカー名')</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td style="text-align:center">
            <img src="/storage/{{$product->image}}" style="height:100px">
          </td>
          <td>{{ $product->product_name }}</td>
          <td>{{ $product->price }}</td>
          <td>{{ $product->stock }}</td>
          <td>{{ $product->companies->company_name}}</td>
          <td><button type="button" onclick="location.href='/product/{{ $product->id }}'" class="btn btn-primary">詳細</button></td>
          <form action="{{route('delete', $product->id)}}" method="POST" onSubmit="return checkDelete()">
            @csrf
            <td><button type="submit" class="btn btn-outline-primary">削除</button></td>
          </form>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pb-5">{{ $products->appends(request()->query())->links() }}</div>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
<script>
$(document).ready(function() 
    { 
        $("#sort_table").tablesorter(); 
    } 
);
</script>
@endsection