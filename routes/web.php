<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('auth/login');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//商品一覧画面を表示
Route::get('/product/list', 'ProductController@showList')->name('productList');

//検索機能
// Route::get('/product/list', 'ProductController@search')->name('search');

//ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//ユーザー新規登録
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// // ログイン画面を表示
// Route::get('/', 'AuthController@showLogin')->name('showLogin');

// //ログインの処理
// Route::post('product/list', 'AuthController@login')->name('login');

// //ログイン後の画面遷移 → 商品一覧へ
// Route::get('/product/list', 
// function(){
//   return view('product.list');
// }
// )->name('afterLogin');


// //ユーザー新規登録画面を表示
// Route::get('/login/userCreate', 'AuthController@showUserCreate')->name('showUserCreate');

// //ユーザー新規登録の処理
// Route::post('/login/userStore', 'AuthController@exeUserStore')->name('exeUserStore');

// //商品一覧画面を表示
// Route::get('/product/list', 'ProductController@showList')->name('products');

//商品新規登録画面を表示
Route::get('/product/create', 'ProductController@showCreate')->name('create');

//新商品登録
Route::post('/product/list', 'ProductController@exeStore')->name('store');


//商品詳細画面を表示
Route::get('/product/{id}', 'ProductController@showDetail')->name('detail');




//商品編集画面を表示
Route::get('/product/edit/{id}', 'ProductController@showEdit')->name('edit');

//編集の登録処理
Route::post('/product/update', 'ProductController@exeUpdate')->name('update');

//商品削除
Route::post('/product/delete/{id}', 'ProductController@exeDelete')->name('delete');