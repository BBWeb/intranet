<tr class="private-task" data-id="{{ $privateTask->id }}">
  <td>
    <input type="text" class="form-control name" value="{{ $privateTask->name }}">
  </td>
  <td>
    <input type="number" class="form-control report" value="{{ $privateTask->time_worked }}">
  </td>
  <td class="valign">
   <a href="#">
    <span class="connect glyphicon glyphicon-random"></span>
  </a>
  <span class="remove-report glyphicon glyphicon-minus pull-right"></span>
</td>
</tr>