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
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <i class="fa fa-dropbox"></i>
            <a href="{{ url('/') }}"> {{ trans('label.app_name') }} </a>
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
                            {!! Html::image(Auth::user()->avatar, null , ['class' => 'avatar']) !!}
                            {{ Auth::user()->name }}<span class="caret"></span>
                        </a>
                        <div class="menu">
                            <a class="item" href="{{ url('/logout') }}">
                                <i class="fa fa-btn fa-sign-out fa-fw"></i>
                                {{ trans('label.logout') }}
                            </a>
                            <div class="item">
                                @if(Auth::user()->isAdmin())
                                    {{ link_to_route('admin.profile', trans('user.profile'),  Auth::user()->id, ['class' => 'fa fa-btn fa-user fa-fw']) }}
                                @else
                                    {{ link_to_route('users.edit', trans('user.profile'),  Auth::user()->id, ['class' => 'fa fa-btn fa-user fa-fw']) }}
                                @endif
                            </div>
                            <a class="item" href="{{ route('contact') }}">
                                <i class="fa fa-btn fa-bolt fa-fw"></i>
                                {{ trans('label.contact') }}
                            </a>
                            <a class="item" href="{{ route('contact') }}">
                                <i class="fa fa-btn fa-bolt fa-fw"></i>
                                {{ trans('label.contact') }}
                            </a>
                            <a class="item" href="{{ url('/profile') }}">
                                <i class="fa fa-btn fa-bolt fa-fw"></i>
                                {{ trans('label.language') }}
                            </a>
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
<script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/all.js') }}"></script>
@if (!Auth::guest())
    <div id="page-wrapper">
        @yield('content')
    </div>
@else
    @yield('content')
@endif

</body>
</html>
