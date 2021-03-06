@extends('admin.customer-report.base')

@section('content')
	@parent

	<div class="row">
		<div class="col-md-12">
			<h2>{{ $project->name }} <small>{{ $from }} - {{ $to }}</small></h2>
			<p>Total tid {{ $totalTimeHours }} timmar {{ $totalTimeMinutes }} minuter - ({{ $totalTime }} minuter)</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table" id="project-tasks">
				<thead>
					<tr>
						<th>Uppgift</th>
						<th>Rapporterad tid</th>
						<th>Rapporterad tid (min)</th>
						<th>Tid (min)</th>
						<th>Datum rapporterat</th>
					</tr>
				</thead>
				<tbody>
					@foreach($tasks as $task)
					<tr data-id="{{ $task->id }}">
						<td>{{ $task->modifiedNameIfAny() }}</td>
						<td>{{ $task->formattedTotalTime() }}</td>
						<td>{{ $task->totaltime() }}</td>
						<td><input type="number" min="0" name="adjusted-time" class="adjusted-time" value="{{ $task->adjustedTimeIfAny() }}" style="width: 60px"></td>
						<td>{{ $task->modifiedDateIfAny() }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-primary" href="{{ Request::url() }}/print">Generera</a>
		</div>
	</div>
@stop

