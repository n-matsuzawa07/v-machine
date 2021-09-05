<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    /**
     * 商品一覧を表示する
     * 
     * @return view
     */
    public function showList(Request $request)
    {
        // $makers = DB::table('products')
        //         ->join('companies','companies.company.id','=','products.company_id');

        //メーカーをDBから引っ張る
        $companies = DB::table('companies')
                ->select('companies.company_name')
                ->get();

        // $companies = Company::find($id);
        // $products = $companies->company_name;

        //検索ワードをDBから引っ張る
        $keyword = $request->input('keyword');
        $keyword2 = $request->input('keyword2');
        $query = Product::query();

        if(!empty($keyword)){
            $query->where('product_name','LIKE','%'.$keyword.'%');
        }
        if(!empty($keyword2) && $keyword2 != ('選択してください')){
            $query->where('company_name', 'LIKE', $keyword2);
        }

        $products = $query->get();
        //ただ全件引っ張るだけなら下記でOK
        // $products = Product::all();
        // dd($products);

        return view('product.list',compact('companies','products','keyword'));
    }


    /**
     * 検索機能実装する
     * 
     * @return view
     */
    // public function search(Request $request)
    // {

    //     //検索ワードをDBから引っ張る
    //     $keyword = $request->input('keyword');
    //     $query = Product::query();

    //     if(!empty($keyword)){
    //         $query->where('product_name','LIKE','%'.$keyword.'%');
    //     }


        // return view('product.list',[keyword => $keyword]);


    //    $searches = Post::orderBy('created_at','asc')
    //              ->where(function($query){
    //                  //
    //                 if($search = request('search')){
    //                     $query->where('title','LIKE',"%{$search}%")->orWhere()
    //                 }
    //              })

        // $products = Product::all();
        // return view('product.list',['products' => $products],['companies' => $companies]);
    

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
    //   dd($inputs);
      //YouTubeのやつ
      $image = $request->file('image');
    //   dd($image);

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
    // dd($maker_name);
    //メーカー名（company_name）からCompanyモデルのidと紐づける
    $input_company_id = DB::table('products')->join('companies', 'products.company_id', '=', 'companies.id')->where('company_name', $maker_name)->value('company_id');
    dd($input_company_id);
        
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
      return redirect(route('productList'));
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
    //   dd($inputs);
      //YouTubeのやつ
      $image = $request->file('image');
    //   dd($image);

      //画像がアップロードされていればstorageに保存
      if($request->hasfile('image')){
          $path = \Storage::put('/public', $image);
          $path = explode('/', $path);
      }else{
          $path[1] = null;
      }
    //   dd($path);

    //   商品を登録
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


    //   //商品のデータを受け取る
    //   $inputs = $request->all();

    //   //商品を編集
    //   \DB::beginTransaction();
    //   try{
    //   //商品情報を編集
    //   $product = Product::find($inputs['id']);
    //   $product->fill([
    //       'product_name' => $inputs['product_name'],
    //       'company' => $inputs['company'],
    //       'price' => $inputs['price'],
    //       'stock' => $inputs['stock'],
    //       'comment' => $inputs['comment'],
    //   ]);
    //   $product->save();

    //   \DB::commit();
    //   }catch(\Throwable $e){
    //     \DB::rollback();
    //     $e->getMessage();
    //   }
      
    //   \Session::flash('err_msg', '商品を更新しました');
    //   return redirect(route('edit',['product' => $product]));
    //     // return view('product.edit',['product' => $product]);
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

        $delImage = Product::find;

        try{
            //商品を削除
            Product::destroy($id);
        }catch(\Throwable $e){
            abort(500);
        }

        \Session::flash('err_msg', '削除しました。');
        return redirect(route('productList'));
    }
    
}