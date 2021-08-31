<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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

    public function companies(){
        return $this->belongsTo('App\Company','company_id');
    }    
}