<tr data-id="{{ $task->id }}" class="first-level task">
  <td>{{ $task->theproject->name }}</td>
  <td>{{ $task->task }}</td>
  <td class="totaltime">{{ $task->totaltime() }}</td>
  <td>
    <span class="glyphicon glyphicon-chevron-right pull-right expand-task"></span>
  </td>
</tr> 
@foreach($task->subreports as $subreport)
<tr data-id="{{ $subreport->id }}" class="second-level hide subreport">
  <td colspan="2">A name</td>
  <td><input type="number" class="form-control" value="{{ $subreport->time }}"></td> 
  <td class="valign"><span class="remove-report glyphicon glyphicon-minus pull-right"></span></td>
</tr>
@endforeach