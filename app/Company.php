<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //テーブル名
    protected $table = 'companies';

    //可変項目
    protected $fillable =
    [
        'company_name',
        'street_address',
        'create_at',
        'updated_at'
    ];

    public function products(){
        return $this->hasMany('App\Product');
    }
}