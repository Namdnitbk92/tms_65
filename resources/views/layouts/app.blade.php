<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.css">
    <link rel="stylesheet" href="http://formvalidation.io/vendor/formvalidation/css/formValidation.min.css">
    @yield('css')
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <i class="fa fa-dropbox"></i>
            @can('is_admin', Auth::user())
                <a href="{{ url('admin/home') }}"> {{ trans('label.app_name') }} </a>
            @else
                <a href="{{ url('users/home') }}"> {{ trans('label.app_name') }} </a>
            @endcan
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <div class="input-group custom-search-form input-search col-md-5 col-sm-5 col-lg-5">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
            <ul class="nav navbar-nav navbar-right margin-top-3">
                @if (Auth::guest())
                    <li>
                        <a href="{{ url('/login') }}">
                            <i class="fa fa-sign-in"></i>
                            {{ trans('label.login') }}
                        </a>
                    </li>
                @else
                    <div class="ui simple dropdown item dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {!! Html::image(Auth::user()->avatar ? Auth::user()->avatar : asset('images\trainee.png'), null , ['class' => 'avatar']) !!}
                            {{ Auth::user()->name }}<span class="caret"></span>
                        </a>
                        <div class="menu">
                           <a class="item" href="{{ url('/logout') }}">
                               <i class="fa fa-btn fa-sign-out fa-fw"></i>
                               {{ trans('label.logout') }}
                           </a>
                           @if(Auth::user()->isAdmin())
                               <a class="item" href="{{ route('admin.profile', [Auth::user()->id]) }}">
                                   <i class="fa fa-btn fa-sign-out fa-fw"></i>
                                   {{ trans('user.profile') }}
                               </a>
                           @else
                               <a class="item" href="{{ route('users.edit', [Auth::user()->id]) }}">
                                   <i class="fa fa-btn fa-sign-out fa-fw"></i>
                                   {{ trans('user.profile') }}
                               </a>
                           @endif
                           <a class="item" href="{{ route('contact') }}">
                               <i class="fa fa-btn fa-bolt fa-fw"></i>
                               {{ trans('label.contact') }}
                           </a>
                           <div class="ui right pointing dropdown link item">
                               <i class="dropdown icon"></i>
                               {{ trans('user.language') }}
                               <div class="menu">
                                   <div class="item"><a href=" {{ route('lang', 'en') }} ">
                                       <i class="us flag"></i>
                                       {{ trans('user.english') }}</a>
                                   </div>
                                   <div class="item"><a href="{{ route('lang', 'vi') }}">
                                       <i class="vietnam flag"></i>
                                       {{ trans('user.vietnamese') }}</a>
                                   </div>
                               </div>
                           </div>
                        </div>
                    </div>
                @endif
            </ul>
        </div>
    </div>
    @if (!Auth::guest())
       @include('layouts.navbar')
    @endif
</nav>
<div id="_loader" class="loadingArea" style="display: none;">
    <img src="{{ asset('images/loading.gif') }}" alt="Loading..."/>
</div>

@if (!Auth::guest())
    <div id="page-wrapper">
        @yield('content')
    </div>
@else
    @yield('content')
@endif

<script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/all.js') }}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="http://formvalidation.io/vendor/formvalidation/js/formValidation.min.js"></script>
<script src="http://formvalidation.io/vendor/formvalidation/js/framework/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/4.2.6/highcharts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/4.2.6/highcharts-3d.js"></script>
</body>
</html>
