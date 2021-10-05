<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;
    //テーブル名
    protected $table = 'products';

    //可変項目
    protected $fillable =
    [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'image',
        'create_at',
        'updated_at'
    ];

    //ソートに使うカラムを追加
    public $sortable = [
        'id',
        'company_id',
        'product_name',
        'price',
        'stock',
        'image',
    ];

    public function companies(){
        return $this->belongsTo('App\Company','company_id');
    }    
}