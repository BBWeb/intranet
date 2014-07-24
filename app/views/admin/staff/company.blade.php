@extends('admin.staff.base')

@section('header')
<h1>Företagsuppgifter</h1>
@stop

@section('form')
{{ Form::open(['route' => ['staff.updatecompany', $staff->id], 'method' => 'PUT']) }}
        <div class="form-group">
          <label for="employment_nr">Anställningsnummer</label>
          {{ Form::text('employment_nr', $staff->employmentNr, ['class' => 'form-control', 'placeholder' => '33'])}}
        </div>

        <div class="form-group">
          <label for="bank">Bank</label>
          {{ Form::text('bank', $staff->bank, ['class' => 'form-control', 'placeholder' => 'Swedbank'])}}
        </div>

        <div class="form-group">
          <label for="clearing_nr">Clearingnummer</label>
          {{ Form::text('clearing_nr', $staff->clearingNr, ['class' => 'form-control', 'placeholder' => '131'])}}
        </div>

        <div class="form-group">
          <label for="bank_nr">Banknummer</label>
          {{ Form::text('bank_nr', $staff->bankNr, ['class' => 'form-control', 'placeholder' => '131 133 - 131'])}}
        </div>
          {{ Form::submit('Spara betalningsinfo', ['class' => 'btn btn-default'])}}
{{ Form::close() }}
@stop