<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $fillable = [
        'nama'
    ];

    public function suplier(){
        return $this->hasMany('App\Suplier','kota_id');
    }
}
