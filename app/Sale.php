<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //テーブル名
    protected $table = 'sales';

    //可変項目
    protected $fillable =
    [
        'product_id'
    ];
}