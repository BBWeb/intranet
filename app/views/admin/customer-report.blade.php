@extends('layouts.authenticated')

@section('content')

 <div class="row">
	<div class="col-md-4">
  	<p>Projekt</p>

	<select class="form-control">
	@foreach($projects as $project)
  		<option>{{ $project->project }}</option>
	@endforeach
	</select>
</div>
<div class="col-md-2">
 <p>Från</p>
 <input class="span2" size="16" id="dp3" type="text" value="12-02-2012" data-date-format="dd-mm-yyyy">
</div>

<div class="col-md-2">
 <p>Till</p>
 <input class="span2" size="16" id="dp3" type="text" value="12-02-2012" data-date-format="dd-mm-yyyy">
</div>

<button type="button" class="btn btn-primary">Sök</button>
</div>


@stop


@section('footer-scripts')
   <script src="js/customer-report.js"></script>
@stop