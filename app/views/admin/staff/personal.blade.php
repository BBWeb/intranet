@extends('admin.staff.base')

@section('header')
<h1>Personuppgifter</h1>
@stop

@section('form')
{{ Form::open() }}

<div class="form-group">
  <label for="ssn">Personnummer</label>
  {{ Form::text('Personnummer', null, ['class' => 'form-control', 'placeholder' => '121212-12'])}}
</div>

<div class="form-group">
  <label for="address">Adress</label>
  {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Hagforsgatan 72'])}}
</div>

<div class="form-group">
  <label for="postal_code">Postnummer</label>
  {{ Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => '416 74'])}}
</div>

<div class="form-group">
  <label for="city">Ort</label>
  {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Göteborg'])}}
</div>

<div class="form-group">
  <label for="tel">Telefon</label>
  {{ Form::text('tel', null, ['class' => 'form-control', 'placeholder' => '031 - 33 44 55'])}}
</div>

{{ Form::submit('Spara personuppgifter', ['class' => 'btn btn-default'])}}

{{ Form::close() }}
@stop
