@extends('admin.changes.base')

@section('content')
	@parent

	<div class="row">
		<div class="col-md-12">
			<h2>{{ $project->name }}</h2>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table" id="project-tasks">
				<thead>
					<tr>
						<th>Uppgift</th>
						<th>Datum rapporterat</th>
						<th>Nytt datum</th>
					</tr>
				</thead>
				<tbody>
					@foreach($project->orderedTasks as $task)
					<tr data-id="{{ $task->id }}">
						<td>{{ $task->task }}</td>
						<td>
							@if ($task->reported_date == '0000-00-00')
							Icke avslutad
							@else
							{{$task->reported_date }}
							@endif
						</td>
						<td>
							Nytt datum
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

