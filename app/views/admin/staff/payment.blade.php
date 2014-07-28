@extends('admin.staff.base')

@section('header')
<h1>Löneinformation</h1>
@stop

@section('form')
<div class="row">
  <ul class="list-inline">
    <li><a href="#" data-toggle="modal" data-target="#history-modal">Historik</a></li>
    <li><a href="#">Planerade lönebyten</a></li>
    <li><a href="#">Ny lön</a></li>
  </ul>
</div>
<div class="row">

  <div class="form-group">
    <label for="">Avdrag inkomstskatt (%)</label>
      <input type="text" value="{{ $staff->currentIncomeTax }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="">Timlön (kr)</label>
    <input type="text" value="{{ $staff->currentHourlySalary }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="">Arbetsgivaravgift (%)</label>
    <input type="text" value="{{ $staff->currentEmployerFee }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="#">Gällande från</label>
    <input type="text" value="{{ $staff->currentStartDate }}" class="form-control" disabled>
  </div>

</div>

<!-- history modal -->
<div class="modal fade" id="history-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Lönehistorik</h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
             <tr>
              <th>Gällande från</th> 
              <th>Timlön</th> 
              <th>Avdragen inkomstskatt</th> 
              <th>Arbetsgivaravgift</th> 
             </tr>
           </thead> 
           <tbody>
            @foreach ($staff->getOldPaymentInfo() as $paymentInfo) 
            <tr>
              <td>{{ $paymentInfo->start_date }}</td>              
              <td>{{ $paymentInfo->hourly_salary }} kr</td>              
              <td>{{ $paymentInfo->income_tax }} %</td>              
              <td>{{ $paymentInfo->employer_fee }} %</td>              
            </tr>
            @endforeach 
           </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop
