<div class="form-group {!! $errors->has('nama') ? 'has-error' : '' !!}">
	{!! Form::label('nama', 'Nama Suplier', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
			{!! Form::text('nama', null, ['class'=>'form-control']) !!}
		<div class="form-control-focus"></div>
		{!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
	{!! Form::label('email', 'E-mail', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
			{!! Form::text('email', null, ['class'=>'form-control']) !!}
		<div class="form-control-focus"></div>
		{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {!! $errors->has('kota_id') ? 'has-error' : '' !!}">
	{!! Form::label('kota_id', 'Nama Kota', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
		{!! Form::select('kota_id', ['' => '']+App\Kota::pluck('nama','id')->all(),null, ['class'=>'form-control']) !!}
		<div class="form-control-focus"></div>
		{!! $errors->first('kota_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {!! $errors->has('tahun_kelahiran') ? 'has-error' : '' !!}">
	{!! Form::label('tahun_kelahiran', 'Tahun Kelahiran', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
		@if(empty($data))
			{!! Form::select('tahun_kelahiran',[''=>'']+App\Suplier::list_tahun() ,null, ['class'=>'form-control']) !!}
		@else
			{!! Form::text('tahun_kelahiran',$tahun_kelahiran, ['class'=>'form-control','readonly']) !!}
		@endif
		<div class="form-control-focus"></div>
		{!! $errors->first('tahun_kelahiran', '<p class="help-block">:message</p>') !!}
	</div>
</div>