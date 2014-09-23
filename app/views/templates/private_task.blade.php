<tr class="private-task" data-id="{{ $privateTask->id }}">
  <td>
    <input type="text" class="form-control name" value="{{ $privateTask->name }}">
  </td>
  <td>
    <input type="number" class="form-control report" value="{{ $privateTask->time_worked }}">
  </td>
  <td class="valign">
    <div class="badge timer">00:00:00</div>
    <span class="remove-report glyphicon glyphicon-minus pull-right"></span>
    <a style="margin-right: 10px" class="pull-right" href="#"><span class="connect glyphicon glyphicon-random"></span></a>
    </td>
</tr>