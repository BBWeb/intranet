@extends('layouts.authenticated')

@section('content')

 <div class="row">
 	{{ Form::open(array('url' => 'staff-report', 'method' => 'get')) }}
	<div class="col-md-2">
		<select name="user" id="user" class="form-control">
			@foreach($users as $user)
		  		<option value="{{ $user->id }}" @if(Request::segment(2) == $user->id)selected="selected" @endif>{{ $user->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="col-md-2">
		 <div class="input-group date">
		 	<span class="input-group-addon">Från</span>
		 	<input type="text" name="from" id="from-date" class="form-control">
		 </div>
	</div>

	<div class="col-md-2">
		<div class="input-group date">
	 		<span class="input-group-addon">Till</span>
	 		<input type="text" name="to" id="to-date" class="form-control" >
	 	</div>
	</div>

	<div class="col-md-2">
		<button type="submit" id="search-user-tasks" class="btn btn-primary">Sök</button>
	</div>
	{{ Form::close() }}
</div>
@stop

@section('footer-scripts')
	<script src="/js/staff-report.js"></script>
	<script src="/js/libs/jquery.noty.packaged.min.js"></script>

@stop