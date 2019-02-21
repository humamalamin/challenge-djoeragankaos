<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    protected $fillable = [
        'nama','email','kota_id','umur'
    ];

    public function produk(){
        return $this->hasMany('App\Produk','suplier_id');
    }

    public function kota(){
        return $this->belongsTo('App\Kota','kota_id');
    }

    public static function list_tahun(){
        $list = array();
        $tahun_sekarang = date('Y');
        $tahun_minimal = $tahun_sekarang - 30;
        for($i = $tahun_sekarang ; $i >= $tahun_minimal ; $i--){
            $list[$i] = $i;
        }

        return $list;
    }
}
