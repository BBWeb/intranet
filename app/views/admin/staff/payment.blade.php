@extends('admin.staff.base')

@section('header')
<h1>Löneinformation</h1>
@stop

@section('form')
<div class="row">
  <ul class="list-inline">
    <li><a href="#" data-toggle="modal" data-target="#history-modal">Historik</a></li>
    <li><a href="#" data-toggle="modal" data-target="#planned-modal">Planerade lönebyten</a></li>
    <li><a href="#" data-toggle="modal" data-target="#plan-salary-modal">Ny lön</a></li>
  </ul>
</div>
<div class="row">

  <div class="form-group">
    <label for="">Avdrag inkomstskatt (%)</label>
      <input type="text" id="current-income-tax" value="{{ $staff->currentIncomeTax }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="">Timlön (kr)</label>
    <input type="text" id="current-hourly-salary" value="{{ $staff->currentHourlySalary }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="">Arbetsgivaravgift (%)</label>
    <input type="text" id="current-employer-fee" value="{{ $staff->currentEmployerFee }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="#">Gällande från</label>
    <input type="text" id="current-start-date" value="{{ $staff->currentStartDate }}" class="form-control" disabled>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Stäng</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- planned salary changes modal -->
<div class="modal fade" id="planned-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Planerade lönebyten</h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
             <tr>
              <th>Gällande från</th>
              <th>Timlön</th>
              <th>Avdragen inkomstskatt</th>
              <th>Arbetsgivaravgift</th>
              <th></th>
             </tr>
           </thead>
           <tbody>
            @foreach ($staff->getFuturePaymentInfo() as $paymentInfo)
            <tr>
              <td>{{ $paymentInfo->start_date }}</td>
              <td>{{ $paymentInfo->hourly_salary }} kr</td>
              <td>{{ $paymentInfo->income_tax }} %</td>
              <td>{{ $paymentInfo->employer_fee }} %</td>
              <td>
                <span data-id="{{ $paymentInfo->id }}" data-staff-id="{{ $staff->id }}" class="remove-salary-change glyphicon glyphicon-remove"></span>
              </td>
            </tr>
            @endforeach
           </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Stäng</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- plan salary change modal -->
<div class="modal fade" id="plan-salary-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Planera lönebyte</h4>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-6">
            <form role="form">
              <div class="form-group">
                <label for="income-tax">Avdrag inkomstskatt (%)</label>
                <input type="number" id="income-tax" value="30" data-default="30" class="form-control" placeholder="30">
                <span id="income-tax-error" class="text-danger hidden"></span>
              </div>

              <div class="form-group">
                <label for="hourly-salary">Timlön</label>
                <input type="number" id="hourly-salary" class="form-control" placeholder="200">
                <span id="hourly-salary-error" class="text-danger hidden"></span>
              </div>

              <div class="form-group">
                <label for="">Arbetsgivaravgift (%)</label>
                <input type="text" id="employer-fee" value="31.42" data-default="31.42" placeholder="31.42" class="form-control">
                <span id="employer-fee-error" class="text-danger hidden"></span>
              </div>

              <div class="form-group">
                <label for="#">Gällande från (åååå-mm-dd)</label>
                <input type="text" id="start-date" placeholder="2014-04-16" class="form-control">
                <span id="start-date-error" class="text-danger hidden"></span>
              </div>

            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Stäng</button>
        <button type="button" data-staff-id="{{ $staff->id }}" id="plan-salary-btn" class="btn btn-success">Spara</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop

@section('footer-scripts')
  <script src="/js/payment.js"></script>
@stop
