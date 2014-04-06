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
		<button type="submit" id="search-user-tasks" class="btn btn-primary">Sök</button>
	</div>
	{{ Form::close() }}
</div>
@stop

@section('footer-scripts')
   <script src="/js/staff-report.js"></script>
@stop