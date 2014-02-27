@extends('layouts.authenticated')

@section('content')

<div class="container">
   @if($errors)
      @foreach($errors as $error)
         <p>{{ $error }}</p>
      @endforeach
   @endif
	<h1>Account</h1>
	<div class="row">
		<div class="col-md-3">
			<form role="form">
				<div class="form-group">
		    		<label for="email">Email</label>
		    		<input type="email" class="form-control" value="{{ Auth::User()->email }}" disabled>
		  		</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<form role="form" method="post" action="account/update-apikey">
				<div class="form-group">
		    		<label for="api-key">Api-nyckel</label>
		    		<input type="text" class="form-control" id="api-key" name="api-key" placeholder="Enter api key" value="{{ Auth::User()->api_key }}">
		  		</div>
		  		<button type="submit" class="btn btn-default">Uppdatera</button>
			</form>
		</div>
	</div>

   <div class="row" style="margin-top: 30px">
      <div class="col-md-3">
         <form role="form" method="post" action="account/update-password">
            <div class="form-group">
               <label for="password">Lösenord</label>
               <input type="password" class="form-control" id="password" name="password" placeholder="Lösenord" >
            </div>
            <div class="form-group">
               <label for="password">Verifiera lösenord</label>
               <input type="password" class="form-control" id="password-confirmation" name="password_confirmation" placeholder="Lösenord" >
            </div>
            <button type="submit" class="btn btn-default">Uppdatera lösenord</button>
         </form>
      </div>
   </div>

</div> <!-- /container -->
@stop
