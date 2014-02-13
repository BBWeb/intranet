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
            <li {{ (Request::is('/') ? ' class="active"' : '') }}><a href="/">Projekt</a></li>
            <li {{ (Request::is('reported-time') ? ' class="active"' : '') }}><a href="/reported-time">Rapporterad tid</a></li>

            @if ( Auth::user()->admin )
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Personal <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/staff">Hantera</a></li>
                <li><a href="/staff/create">Lägg till</a></li>
              </ul>
            </li>

            <li {{ (Request::is('time') ? ' class="active"' : '') }}><a href="/time">Rapporterad tid (admin)</a></li>
            <li><a href="">Kundvy</a></li>
            @endif

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Acccount <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/account">Account</a></li>
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
