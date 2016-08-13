<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav in" id="side-menu">
            <li>
                @can('is_admin', Auth::user())
                    <a href="{{ route('dashboard') }}" class="active"><i class="fa fa-dashboard fa-fw"></i>
                        {{ trans('label.dashboard') }}
                    </a>
                @else
                    <a href="{{ route('dashboardUser') }}" class="active"><i class="fa fa-dashboard fa-fw"></i>
                        {{ trans('label.dashboard') }}
                    </a>
                @endcan
            </li>
            <li class="">
                <a href="#">
                    <i class="fa fa-bar-chart-o fa-fw"></i>
                    {{ trans('label.chart') }}
                    <span class="fa arrow"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.courses.index') }}">
                    <i class="fa fa-table fa-fw"></i>
                    {{ trans('label.course') }}
                </a>
            </li>
            <li>
                @can('is_user', Auth::user())
                <a href="{{ route('user.subject.index', ['user' => auth()->user()->id]) }}">
                    <i class="fa fa-book fa-fw"></i>
                    {{ trans('label.subject') }}
                </a>
                @else
                {!! Html::decode(link_to_route(
                    'admin.subjects.index',
                    '<i class="fa fa-book fa-fw"></i> ' . trans('label.subject')
                )) !!}
                @endcan
            </li>
            @can('is_admin', Auth::user())
            <li>
                {!! Html::decode(link_to_route(
                    'admin.tasks.index',
                    '<i class="fa fa-tasks fa-fw"></i> ' . trans('label.task')
                )) !!}
            </li>
            @endcan
            @can('is_user', Auth::user())
            <li>
                {!! Html::decode(link_to_route(
                    'users.tasks.index',
                    '<i class="fa fa-tasks fa-fw"></i> ' . trans('label.task'),
                    [Auth::user()->id]
                )) !!}
            </li>
            @endcan
        </ul>
    </div>
</div>
