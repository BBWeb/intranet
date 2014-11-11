<tr data-id="{{ $task->id }}" class="first-level task">
  <td>{{ $task->projectName }}</td>
  <td class="name">{{ $task->taskName }}</td>
  <td class="totaltime">{{ $task->formattedTotalTime() }}</td>
  <td>
    <span class="glyphicon glyphicon-chevron-right pull-right expand-task"></span>
    <span style="margin-right: 7px" class="hide glyphicon glyphicon-plus pull-right add-subreport"></span>
  </td>
</tr>
@foreach($task->subreports as $subreport)
<tr data-id="{{ $subreport->id }}" class="second-level hide subreport @if($subreport->payed) payed @endif">
@if ($subreport->payed)
  <td class="valign" colspan="2"><input type="text" class="form-control name" value="{{ $subreport->name }}" disabled="true"></td>
  <td><input type="number" class="form-control time" value="{{ $subreport->time }}" disabled="true"></td>
  <td class="valign">
    {{ $subreport->formattedTime() }}
  </td>
@else
   <td class="valign" colspan="2"><input type="text" class="form-control name" value="{{ $subreport->name }}"></td>
  <td><input type="number" class="form-control time" value="{{ $subreport->time }}"></td>
  <td class="valign">
    <span class="formatted-time">{{ $subreport->formattedTime() }}</span>
    <!-- <div class="badge timer">00:00:00</div> -->
    <span class="remove-report glyphicon glyphicon-minus pull-right"></span>
  </td>
  @endif
</tr>
@endforeach
