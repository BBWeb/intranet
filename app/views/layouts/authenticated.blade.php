@extends('layouts.base')

@section('base-content')
    <div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">B&B Web - Intranet</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li {{ (Request::is('/') ? ' class="active"' : '') }}><a href="/">Tidsrapportering</a></li>
            <li {{ (Request::is('reported-time/*') ? ' class="active"' : '') }}><a href="/reported-time">Rapporterad tid</a></li>

            @if ( Auth::user()->admin )
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Personal <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/staff">Hantera</a></li>
                <li><a href="/staff/create">Lägg till</a></li>
              </ul>
            </li>

            <li class="{{ (Request::is('staff-report*') ? 'active' : '') }} dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Lönevy <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/staff-report">Obetalt</a></li>
                <li><a href="/staff-report/payed">Utbetalt</a></li>
              </ul>
            </li>
<!--             <li {{ (Request::is('time') ? ' class="active"' : '') }}><a href="/staff-report">Lönevy</a></li>
 -->
            <li><a href="/customer-report">Kundvy</a></li>

            <li class="@if (Request::is('changes*')) active @endif"><a href="/changes">Förändringar</a></li>
            <li class="@if (Request::is('archive')) active @endif"><a  href="/archive">Arkivera projekt</a></li>
            @endif

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Konto <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/account">Profil</a></li>
                <li class="divider"></li>
                <li><a href="/logout">Log out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="container">
		  @yield('content')
      </div>

    </div> <!-- /container -->

@stop
