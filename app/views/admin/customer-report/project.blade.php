@extends('admin.customer-report.base')

@section('content')
	@parent

	<div class="row">
		<div class="col-md-12">
			<h2>{{ $project->name }} <small>{{ $from }} - {{ $to }}</small></h2>
			<p>Total tid {{ $totalTime }} minuter</p>
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
						<td>{{ $task->task }}</td>
						<td>{{ $task->time_worked }}</td>
						<td>{{ $task->reported_date }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<ul>
	</ul>
@stop

