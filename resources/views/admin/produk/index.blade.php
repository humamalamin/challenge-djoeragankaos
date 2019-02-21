@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-title">
                    <h2 class="card-header">Produk</h2> 
                </div>
                <div class="card-body">
                    <div class="col-md-offset-8 col-md-3">
                        <a href="{{ route('produks.create') }}" class="btn btn-success">Produk Baru</a>
                    </div>
                    <br><br>
                    <div class="table-responsive">
                        {!! $html->table(['class'=>'table table-striped table-bordered  dt-responsive nowrap', 'cellspacing'=>'0',  'width'=>'100%']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
{!! $html->scripts() !!}
@endsection