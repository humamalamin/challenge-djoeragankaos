<div class="form-group {!! $errors->has('nama') ? 'has-error' : '' !!}">
	{!! Form::label('nama', 'Nama Kota', ['class'=>'col-md-2 control-label']) !!}
	<div class="col-md-10">
			{!! Form::text('nama', null, ['class'=>'form-control']) !!}
		<div class="form-control-focus"></div>
		{!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
	</div>
</div>