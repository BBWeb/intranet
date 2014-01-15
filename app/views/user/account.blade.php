@extends('user.base')

@section('content')

<div class="container">
	<h1>Account</h1>
	<div class="row">
		<div class="col-md-3">
			<form role="form">
				<div class="form-group">
		    		<label for="email">Email address</label>
		    		<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="{{ Auth::User()->email }}" disabled>
		  		</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<form role="form" method="post" action="account/update-apikey">
				<div class="form-group">
		    		<label for="api-key">Api key</label>
		    		<input type="text" class="form-control" id="api-key" name="api-key" placeholder="Enter api key" value="{{ Auth::User()->api_key }}">
		  		</div>
		  		<button type="submit" class="btn btn-default">Change key</button>
			</form>
		</div>
	</div>

</div> <!-- /container -->
@stop
