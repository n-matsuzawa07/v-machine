<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use App\Rules\alpha_num_check;



class ProductController extends Controller
{
    /**
     * 商品一覧を表示する
     * 
     * @return view
     */
    public function showList(Request $request)
    {
        //メーカーをDBから引っ張る
        $companies = DB::table('companies')
                ->select('companies.company_name')
                ->get();

    //検索ワードをDBから引っ張る
        //入力値を格納
        $keyword = $request->input('keyword');
        $keyword2 = $request->keyword2;
        $price_low = $request->input('price_low');
        $price_high = $request->input('price_high');
        $hidden_price_low = $request->input('hidden_price_low');
        $hidden_price_high = $request->input('hidden_price_high');
        $stock_low = $request->input('stock_low');
        $stock_high = $request->input('stock_high');
        $hidden_stock_low = $request->input('hidden_stock_low');
        $hidden_stock_high = $request->input('hidden_stock_high');
        // dd($price_high);
        $query = Product::query();

        $query_company_name = DB::table('companies')->select('company_name')->join('products','products.company_id','=','companies.id')->get();

        //商品名検索
        if(!empty($keyword)){
            $query->where('product_name','LIKE','%'.$keyword.'%')->get();
        }
        
        //メーカー検索
        //keyword2を数字に変更する
        $keyword2Id = Company::where('company_name', $keyword2)->value('id');
        //keyword2を文字ではなく数字を引っ張ってくるように変換する
        if(!empty($keyword2) && $keyword2 != ('選択してください')){
            $query->where('company_id', 'LIKE', $keyword2Id)->get();
        }

        //価格検索
        if(!empty($price_low) && !empty($price_high)){
          $query->whereBetween('price',[$price_low, $price_high])->get();
        }else if(!empty($price_low)){
          $query->whereBetween('price',[$price_low, $hidden_price_high])->get();
        }else if(!empty($price_high)){
          $query->whereBetween('price',[$hidden_price_low, $price_high])->get();
        }else{
          $query->get();
        }

        //在庫検索
        if(!empty($stock_low) && !empty($stock_high)){
          $query->whereBetween('stock',[$stock_low, $stock_high])->get();
        }else if(!empty($stock_low)){
          $query->whereBetween('stock',[$stock_low, $hidden_stock_high])->get();
        }else if(!empty($stock_high)){
          $query->whereBetween('stock',[$hidden_stock_low, $stock_high])->get();
        }else{
          $query->get();
        }

        //ページネーション
        $products = $query->sortable()->paginate(5);

        return view('product.list',compact('companies','products','keyword'));
    }
    

    /**
     * 商品詳細を表示する
     * param int $id
     * @return view
     */
    public function showDetail($id)
    {
        // $product = Product::with('companies')->get();
        $product = Product::find($id);
        // dd($products);

        if(is_null($product)){
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('productList'));
        }
        
        return view('product.detail',compact('product'));
    }



    /**
     * 新規登録画面を表示する
     * 
     * @return view
     */
    public function showCreate()
    {
        // メーカーをDBから引っ張る
        $companies = DB::table('companies')
                ->select('companies.company_name')
                ->get();
        
        return view('product.create',['companies'=>$companies]);
    }

    /**
     * 商品を新規登録する
     * 
     * @return view
     */
    public function exeStore(ProductRequest $request)
    {
      //商品のデータを受け取る
      $inputs = $request->all();
      // dd($inputs);
      //YouTubeのやつ
      $image = $request->file('image');
      // dd($image);

      //画像がアップロードされていればstorageに保存
      if($request->hasfile('image')){
          $path = \Storage::put('/public', $image);
          $path = explode('/', $path);
      }else{
          $path[1] = null;
      }

    //   商品を登録
      \DB::beginTransaction();
      try{    
    //メーカー名を取得
    $maker_name = $request->input('company_id');

    //メーカー名（company_name）からCompanyモデルのidと紐づける
    $input_company_id = DB::table('companies')
    ->where('company_name', $maker_name)
    ->value('id');

    // dd($input_company_id);
        $products = new Product;
        $products->fill([
            'product_name' => $inputs['product_name'],
            'company_id' => $input_company_id,
            'price' => $inputs['price'],
            'stock' => $inputs['stock'],
            'comment' => $inputs['comment'],
            'image' => $path[1]
        ]);
        $products->save();
        \DB::commit();
    }catch(\Throwable $e){
        \DB::rollback();
        // abort(500);
        // $e->getMessage();
        \Log::error($e);
        throw $e;
      }
        //   dd($products);
      \Session::flash('err_msg', '商品を登録しました');
      return redirect(route('create'));
    }



    /**
     * 商品編集フォームを表示する
     * param int $id
     * @return view
     */
    public function showEdit($id)
    {
        //メーカーをDBから引っ張る
        $companies = DB::table('companies')
                ->select('companies.company_name')
                ->get();

        $product = Product::find($id);
        
        if(is_null($product)){
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('productList'));
        }
        
        return view('product.edit',['product' => $product],['companies'=>$companies]);
    }

    /**
     * 編集を更新する
     * 
     * @return view
     */
    public function exeUpdate(Request $request)
    {
      //商品のデータを受け取る
      $inputs = $request->all();
      // dd($inputs);
      //YouTubeのやつ
      $image = $request->file('image');
      // dd($image);
      //画像がアップロードされていればstorageに保存
      if($request->hasfile('image')){
          $path = \Storage::put('/public', $image);
          $path = explode('/', $path);
      }else{
          $path[1] = null;
      }
      
    //   商品を更新
      \DB::beginTransaction();
      try{    
    //メーカー名を取得
    $maker_name = $request->input('company_id');
    // メーカー名（company_name）からCompanyモデルのidと紐づける
    $input_company_id = DB::table('products')->join('companies', 'products.company_id', '=', 'companies.id')->where('company_name', $maker_name)->value('company_id');
        
        $product = Product::find($inputs['id']);
        $product->fill([
            'product_name' => $inputs['product_name'],
            'company_id' => $input_company_id,
            'price' => $inputs['price'],
            'stock' => $inputs['stock'],
            'comment' => $inputs['comment'],
            'image' => $path[1]
        ]);
        // dd($path);
        $product->save();
        \DB::commit();
    }catch(\Throwable $e){
        \DB::rollback();
        // abort(500);
        // $e->getMessage();
        \Log::error($e);
        throw $e;
      }
        //   dd($products);
      \Session::flash('err_msg', '商品を更新しました');
      return redirect(route('productList'));
    }

    /**
     * 商品削除フォームを表示する
     * param int $id
     * @return view
     */
    public function exeDelete($id)
    {
        if(empty($id)){
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('productList'));
        }

        $product = Product::find($id);
        $delName = $product->image;
        $pathdel = storage_path() .'/app/public/'. $delName;
        \File::delete($pathdel);

        try{
            //商品を削除
            Product::destroy($id);
        }catch(\Throwable $e){
            abort(500);
        }

        \Session::flash('err_msg', '削除しました。');
        return redirect(route('productList'));
    }

    
    protected function validator(array $data)
{
     return Validator::make($data, [
         'price' => [new alpha_num_check()], 
         'stock' => [new alpha_num_check()], 
     ]);
}
}