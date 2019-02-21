<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Produk;

class IndexController extends Controller
{
    public function index(){
        $data = Produk::with('suplier')->paginate(9);

        return view('welcome',compact('data'));
    }
}
