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
						<th>Kundtitel</th>
						<th>Datum rapporterat</th>
						<th>Kunddatum</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($project->orderedTasks as $task)
					<tr data-id="{{ $task->id }}">
						<td>{{ $task->task }}</td>
						<td>{{ $task->modifiedNameIfAny() }}</td>
						<td>
							@if ($task->reported_date == '0000-00-00')
							Icke avslutad
							@else
							{{$task->reported_date }}
							@endif
						</td>
						<td>
							@if ($task->reported_date == '0000-00-00')
							Icke avslutad
							@else
							{{$task->modifiedDateIfAny() }}
							@endif
						</td>
						<td>
							<button class="btn btn-primary change-button">Förändra</button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="changes-modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Förändra task</h4>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="customer-title">Kundtitel</label>
							<input type="text" class="form-control" id="customer-title" name="customer-title">	
						</div>
						<div class="form-group" id="date-group">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
					<button type="submit" id="update-task-button" class="btn btn-primary sucess-button">Uppdatera</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script type="text/template" id="task-date-template">
		<label for="customer-date">Kunddatum</label>
		<% if (date == '0000-00-00') { %>		
			<p>Icke avslutad</p>
			<button data-id="<%- id %>" class="btn btn-danger finish-task-btn">Avsluta</button>
		<% } else { %>
			<input type="date" class="form-control" id="customer-date" name="customer-date" value="<%- date %>">
		<% } %>
	</script>

@stop

@section('footer-scripts')
<script src="/js/changes.js"></script>
@stop

