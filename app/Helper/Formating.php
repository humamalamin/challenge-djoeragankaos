<?php
namespace App\Helper;

class Formating {

    public static function rupiah($harga)
    {
        return "Rp." . number_format($harga, 0, ',' , '.'); 
    }
    public static function percent($nilai)
    {
        return number_format($nilai, 2, ',' , '.') . ' %'; 
    }
}