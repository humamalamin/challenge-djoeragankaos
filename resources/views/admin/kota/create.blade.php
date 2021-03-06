@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kotas.index')}}">Kota</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-title">
                    <h2 class="card-header">Tambah Kota</h2> 
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'kotas.store', 'class'=>'form-horizontal margin-bottom-40', 'role'=>'form','files' => true])!!}
                        @include('admin.kota._form')
                        <br>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                {!! Form::submit(isset($data) ? 'Update' : 'Save', ['class'=>'btn btn-primary']) !!}
                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection