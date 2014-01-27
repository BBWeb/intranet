@extends('layouts.authenticated')

@section('content')
<div class="container">

   <div class="row">
      <div class="col-md-12">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>Email</th>
                  <th>Admin</th>
                  <th></th>
               </tr>
            </thead>
            <tbody id="staff-members">
			@foreach($staff as $staffMember)
			<tr>
				<td>{{ $staffMember->email }}</td>
				<td>
				@if( $staffMember->admin )
					X
				@endif </td>
				<td><a href="/staff/{{ $staffMember->id }}/edit" class="btn btn-primary">Hantera</a>
					<button class="btn btn-danger remove-button">Ta bort</button>
				</td>
			</tr>
			@endforeach
            </tbody>
         </table>
      </div>
   </div>

   <!-- Modal -->
<div class="modal fade" id="remove-staff-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Bekräfta borttagning av personal</h4>
      </div>
      <div class="modal-body">
       <p>Är du säker på detta?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
        <button type="button" class="btn btn-danger">Bekräfta</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop

@section('footer-scripts')
   <script src="js/manage-staff.js"></script>
@stop
