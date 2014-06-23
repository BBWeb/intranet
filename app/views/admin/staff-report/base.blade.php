@extends('layouts.authenticated')

@section('content')

 <div class="row">
 	{{ Form::open(array('url' => 'staff-report/filter')) }}

	<div class="col-md-2">
	{{ Form::select('user', $users, null, array('class' => 'form-control', 'id' => 'user')) }}
	</div>

	<div class="col-md-2">
		 <div class="input-group date">
		 	<span class="input-group-addon">Från</span>
		 	{{ Form::text('from', null, array('class' => 'form-control', 'id' => 'from-date')) }}
		 </div>
	</div>

	<div class="col-md-2">
		<div class="input-group date">
	 		<span class="input-group-addon">Till</span>
	 		{{ Form::text('to', null, array('id' => 'to-date', 'class' => 'form-control')) }}
	 	</div>
	</div>

	<div class="col-md-2">
	{{ Form::submit('Sök', array('class' => 'btn btn-primary', 'id' => 'search-user-tasks'))}}
	</div>
	{{ Form::close() }}
</div>
@stop

@section('footer-scripts')
	<script src="/js/staff-report.js"></script>
	<script src="/js/libs/jquery.noty.packaged.min.js"></script>

@stop