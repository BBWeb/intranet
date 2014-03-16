@extends('admin.customer-report.base')

@section('content')
	@parent

	<ul>
		@foreach($tasks as $task)
			<li>{{ $task->task }}</li>
		@endforeach
	</ul>
@stop

