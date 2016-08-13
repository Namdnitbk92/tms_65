@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 body-content">
            <h2 class="ui dividing header blue">
                DashBoard
            </h2>
            <div class="ui segment">
                <h2 class="ui right floated header blue">
                    Activity
                </h2>
                <div class="ui clearing divider"></div>
                <div class="ui active centered inline loader loading-ajax"></div>
                <activities style="display:none;"></activities>
            </div>
            <div class="ui two column stackable grid">
                @can('is_user', Auth::user())
                <div class="column">
                    <div class="ui segment">
                        <h4 class="ui horizontal divider header blue">
                          <i class="tag icon"></i>
                          Progress
                        </h4>
                        <div class="ui active centered inline loader loading-ajax" ></div>
                        <div class="progress-content" >
                            <div class="field">
                                @if(isset($course))
                                    {{ Form::select('size', $course, 'please select course', ['name' => 'course']) }}
                                @endif
                            </div>
                            <div class="field">
                                <label>Courses</label>
                                <div class="progress">
                                    <div name="progress-course" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" >
                                        <progress-course></progress-course>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label>Subject</label>
                                <div class="progress progress-subject">

                                </div>
                            </div>
                            <div class="field">
                                <label>Task</label>
                                <div class="progress progress-task">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="column">
                    <div class="ui segment">
                        <div id="subject"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .ui.feed > .event > .label {
            width: 4.5em;
        }
    </style>
    <script>
        var interval = setInterval(function(){
            if (document.readyState === "complete") {clearInterval(interval);activities.build();}
        },200);
    </script>
@endsection
