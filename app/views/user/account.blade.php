@extends('layouts.authenticated')

@section('content')

<div class="container">
	@if ( Session::has('message') )
	<p class="alert alert-success">{{ Session::get('message') }}</p> 
	@endif
	<h1>Account</h1>
	<div class="row">
		<div class="col-md-3">
			<form role="form">
				<div class="form-group">
		    		<label for="email">Email</label>
		    		<input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
		  		</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			{{ Form::open(array('url' => 'account/update-apikey')) }}
				<div class="form-group">
		    		<label for="api-key">Api-nyckel</label>
		    		{{ Form::text('api-key', Auth::user()->api_key, array('placeholder' => 'Enter api key', 'class' => 'form-control', 'id' => 'api-key')) }}
		  		</div>
		  		<button type="submit" class="btn btn-default">Uppdatera</button>
		  	{{ Form::close() }}
		</div>
	</div>

   <div class="row" style="margin-top: 30px">
      <div class="col-md-3">
         {{ Form::open(array('url' => 'account/update-password')) }}
            <div class="form-group">
               <label for="password">Lösenord</label>
               {{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => 'Lösenord' ))}}
               {{ $errors->first('password', '<span class="text-danger">:message</span>') }}
            </div>
            <div class="form-group">
               <label for="password_confirmation">Verifiera lösenord</label>
               {{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'password-confirmation', 'placeholder' => 'Lösenord' ))}}
               {{ $errors->first('password_confirmation', '<span class="text-danger">:message</span>') }}
            </div>
            {{ Form::submit('Uppdatera lösenord', array('class' => 'btn btn-default')) }}
          {{ Form::close() }}
         </form>
      </div>
   </div>

</div> <!-- /container -->
@stop
