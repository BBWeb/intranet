@extends('layouts.authenticated')

@section('content')

 <div class="row">
 	{{ Form::open(array('url' => 'customer-report/filter')) }}
	<div class="col-md-3">
		{{ Form::select('project', $projects, Session::get('projectId'), array('class' => 'form-control', 'id' => 'user')) }}
	</div>
	<div class="col-md-2">
		 <div class="input-group date">
		 	<span class="input-group-addon">Från</span>
		 	{{ Form::text('from', Session::get('from'), array('id' => 'from-date', 'class' => 'form-control')) }}
		 </div>
	</div>

	<div class="col-md-2">
		<div class="input-group date">
	 		<span class="input-group-addon">Till</span>
	 		{{ Form::text('to', Session::get('to'), array('id' => 'to-date', 'class' => 'form-control')) }}
	 	</div>
	</div>

	<div class="col-md-2">
		{{ Form::submit('Sök', array('class' => 'btn btn-primary')) }}
	</div>
	{{ Form::close() }}
</div>
@stop

@section('footer-scripts')
   <script src="/js/customer-report.js"></script>
@stop