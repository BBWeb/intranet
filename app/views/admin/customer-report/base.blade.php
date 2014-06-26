@extends('layouts.authenticated')

@section('content')

 <div class="row">
 	{{ Form::open(array('url' => 'customer-report', 'method' => 'get')) }}
	<div class="col-md-3">
		<select name="project" id="project" class="form-control">
			@foreach($projects as $project)
		  		<option value="{{ $project->id }}">{{ $project->name }}</option>
			@endforeach
		</select>
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
		<button type="submit" id="search-project-tasks" class="btn btn-primary">Sök</button>
	</div>
	{{ Form::close() }}
</div>
@stop

@section('footer-scripts')
   <script src="/js/customer-report.js"></script>
@stop