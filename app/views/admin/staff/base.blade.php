@extends('layouts.authenticated')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-6">
		@yield('header')	
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			@yield('form')
		</div>
		
		<div class="col-md-3">
			<ul class="nav nav-pills nav-stacked">
				<li class="@if ( Route::currentRouteNamed('staff.edit') ) active @endif"><a href="{{ URL::route('staff.edit', [ $staff->id ]) }}">Kontouppgifter</a></li>
				<li class="@if ( Route::currentRouteNamed('staff.personal') ) active @endif"><a href="{{ URL::route('staff.personal', [ $staff->id ]) }}">Personuppgifter</a></li>
				<li class="@if (Route::currentRouteNamed('staff.company')) active @endif"><a href="{{ URL::route('staff.company', [ $staff->id ]) }}">Företagsinfo</a></li>
			</ul>
		</div>	
	</div>

</div>
@stop