@extends('admin.staff.base')

@section('header')
<h1>Kontouppgifter</h1>
@stop

@section('form')
{{ Form::open(array('method' => 'put', 'url' => array('/staff', $staff->id) )) }}
<div class="form-group">
	<label for="name">Namn</label>
	{{ Form::text('name', $staff->name, array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name')) }}
	{{ $errors->first('name', '<span class="text-danger">:message</span>') }}
</div>
<div class="form-group">
	<label for="email">E-mail</label>
	{{ Form::email('email', $staff->email, array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter email', 'disabled' => true)) }}
	{{ $errors->first('email', '<span class="text-danger">:message</span>') }}
</div>
<div class="form-group">
	<label for="exampleInputPassword1">Password</label>
	{{ Form::password('password', array('class' => 'form-control', 'id' => 'password',  'placeholder' => 'Password')) }}
	{{ $errors->first('password', '<span class="text-danger">:message</span>') }}
</div>
<div class="checkbox">
	<label>
		<input type="checkbox" name="admin" value="admin"> Admin
	</label>
</div>
<button type="submit" class="btn btn-default">Ändra</button>
{{ Form::close() }}
@stop
