 <tr data-id="{{ $asanaTask->id }}">
  <td class="task-project">{{ $asanaTask->project->name }}</td>
  <td class="task-name">{{ $asanaTask->name }}</td>
  <td><button class="btn btn-primary connect-task">Koppla</button></td>
</tr>