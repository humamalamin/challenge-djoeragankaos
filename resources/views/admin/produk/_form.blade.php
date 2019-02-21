<div class="form-group {!! $errors->has('nama') ? 'has-error' : '' !!}">
	{!! Form::label('nama', 'Nama Produk', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
			{!! Form::text('nama', null, ['class'=>'form-control']) !!}
		<div class="form-control-focus"></div>
		{!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {!! $errors->has('suplier_id') ? 'has-error' : '' !!}">
	{!! Form::label('suplier_id', 'Suplier', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
		{!! Form::select('suplier_id', ['' => '']+App\Suplier::pluck('nama','id')->all(),null, ['class'=>'form-control']) !!}
		<div class="form-control-focus"></div>
		{!! $errors->first('suplier_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {!! $errors->has('harga') ? 'has-error' : '' !!}">
	{!! Form::label('harga', 'Harga Jual', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
			{!! Form::text('harga', null, ['class'=>'form-control']) !!}
		<div class="form-control-focus"></div>
		{!! $errors->first('harga', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
	{!! Form::label('status', 'Status', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
		{!! Form::checkbox('status',1 ,false) !!}
		<div class="form-control-focus"></div>
		{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {!! $errors->has('image') ? 'has-error' : '' !!}">
	{!! Form::label('image', 'Foto Produk', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
		{!! Form::file('image', null, ['class'=>'form-control']) !!}
		@if(!empty($data))
		<img src="{{$data->image}}" alt="" width="200">
		@endif
		<div class="form-control-focus"></div>
		{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
	</div>
</div>
