@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>List Produk</h1>
            @foreach($data as $key => $value)
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top img-responsive" src="{{ $value->image}}" alt="Card image cap">
                    <div class="card-body" style="text-align:center">
                        <h2 class="card-title">{{ $value->nama}}</h2>
                        <p class="card-text">Rp.{{ number_format($value->harga,0,'.','.')}}</p>
                        <p class="card-text">Suplier <a href="#">{{ $value->suplier->nama}}</a></p>
                    </div>
                </div>
            </div>
            @endforeach
            {!! $data->links() !!}
        </div>
    </div>
</div>
@endsection