<tr data-id="{{ $task->id }}" class="first-level task">
  <td>{{ $task->projectName }}</td>
  <td class="name">{{ $task->taskName }}</td>
  <td class="totaltime">{{ $task->totaltime() }}</td>
  <td>
    <span class="glyphicon glyphicon-chevron-right pull-right expand-task"></span>
  </td>
</tr>
@foreach($task->subreports as $subreport)
<tr data-id="{{ $subreport->id }}" class="second-level hide subreport @if($subreport->payed) payed @endif">
@if ($subreport->payed)
  <td class="valign" colspan="2"><input type="text" class="form-control name" value="{{ $subreport->name }}" disabled="true"></td>
  <td><input type="number" class="form-control time" value="{{ $subreport->time }}" disabled="true"></td>
  <td class="valign"></td>
@else
   <td class="valign" colspan="2"><input type="text" class="form-control name" value="{{ $subreport->name }}"></td>
  <td><input type="number" class="form-control time" value="{{ $subreport->time }}"></td>
  <td class="valign">
    <div class="badge timer">00:00:00</div>
    <span class="remove-report glyphicon glyphicon-minus pull-right"></span>
  </td>
  @endif
</tr>
@endforeach
