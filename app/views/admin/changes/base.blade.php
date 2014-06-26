@extends('layouts.authenticated')

@section('content')

 <div class="row">
 	{{ Form::open(array('url' => 'changes')) }}
 	<div class="col-md-3">
		{{ Form::select('project', $projects, null, array('class' => 'form-control')) }}
	</div>

 	<div class="col-md-2">
 		<button type="submit" id="search-project-tasks" class="btn btn-primary">Sök</button>
 	</div>
 	{{ Form::close() }}
 	</div>
@stop

@section('footer-scripts')
@stop