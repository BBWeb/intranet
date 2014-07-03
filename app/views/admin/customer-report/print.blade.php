@extends('layouts.authenticated')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h2>{{ $project->name }} <small>{{ $from }} - {{ $to }}</small></h2>
			<p>Total tid {{ $hours }} timmar {{ $minutes }} minuter</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>Uppgift</th>
						<th>Tid (minuter)</th>
						<th>Datum rapporterat</th>
					</tr>
				</thead>
				<tbody>
					@foreach($tasks as $task)
					<tr>
						<td>{{ $task->modifiedNameIfAny() }}</td>
						<td>{{ $task->adjusted_time }}</td>
						<td>{{ $task->modifiedDateIfAny() }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop