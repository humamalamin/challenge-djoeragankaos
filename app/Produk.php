<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama','suplier_id','harga','status'
    ];

    public function suplier(){
        return $this->belongsTo('App\Suplier','suplier_id');
    }
}
